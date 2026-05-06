let images =[];
function image_select() {
    let image = document.getElementById('property-gallery-image').files;
    
    for(var i=0;i<image.length;i++){
        if(check_dublicate(image[i].name)){
            images.push({
                "name":image[i].name,
                "url":URL.createObjectURL(image[i]),
                "file":image[i]
            })
        }else{
            alert(image[i].name+" has been already Uploaded")
        }
    }
//    $("#container").html();
    document.getElementById('container').innerHTML= image_show();
}

function image_show() {
    var img="";
   images.forEach((i)=>{
        img += `<div class="image_container d-flex justify-content-center position-relative">
        <img src="${i.url}" alt="Image" srcset="">
        <span class="position-absolute" onclick=delete_image(${images.indexOf(i)})>&times;</span>
        </div>`
   })
   return img;
}

function delete_image(e){
    images.splice(e,1)
    document.getElementById('container').innerHTML= image_show();
}

function check_dublicate(name){
    var dublicate_image = true;
    for(i=0;i<images.length;i++) {
        if(images[i].name ==name){
            dublicate_image =false;
            break;
        }
    }
    return dublicate_image;
}

$(".gallery_image").on('click',function(e){
    e.preventDefault();
    showLoader();
    var curStep = $(this).closest(".setup-content"),curStepBtn = curStep.attr("id"),
    nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a");
    var formData = new FormData();
    formData.append('property_id',$("input[name=property_id]").val());
    formData.append('totalFiles',images.length);
    for(i=0;i<images.length;i++){
        console.log(images[i].file);
        formData.append("files"+i,images[i].file)
    }
    $.ajax({
        url:site_url+"/admin/property/gallery-image-store",
        type:"POST",
        data: formData,
        dataType: "json",
        cache: false,
        contentType: false,  
        processData:false,  
        success:(res)=>{
            if(res.status=='1'){
                hideLoader();
                nextStepWizard.removeAttr('disabled').trigger('click')
            }
        },error(xhr,ajaxOptions,thrownError){
            hideLoader();
            let error = xhr.responseJSON.errors;
            if(xhr.status=="422"){
                $(".all_rates_are_in").html("");
                $(".all_rates_are_in").html(error.all_rates_are_in );
            }else{
                showToaster("bg-danger","top-0 end-0",xhr.responseJSON.message);
            }
        }
    })
});