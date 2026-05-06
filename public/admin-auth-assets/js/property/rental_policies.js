var rentalPoliciesDescription;
var cancelPolicesDescription;
$(function () {
    ClassicEditor.create( document.querySelector( '#rental_policies' ) ).then( editor => {
        rentalPoliciesDescription = editor;
    }).catch( error => {
        console.error( error );
    });
    ClassicEditor.create( document.querySelector( '#cancel_polices' ) ).then( editor => {
        cancelPolicesDescription = editor;
    }).catch( error => {
        console.error( error );
    });
})


$(".rental_policies").on("click",function(e){
    e.preventDefault();
    showLoader();
    var curStep = $(this).closest(".setup-content"),curStepBtn = curStep.attr("id"),
    nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a");
    var formData = new FormData();
    formData.append('property_id',$("input[name=property_id]").val());
    formData.append('rental_policies',rentalPoliciesDescription.getData());
    formData.append('cancel_polices',cancelPolicesDescription.getData());
    formData.append('upload_rental_policies',$("input[name=upload_rental_policies]").prop('files')[0] !=undefined?$("input[name=upload_rental_policies]").prop('files')[0]:"");
    formData.append('upload_cancel_policies',$("input[name=upload_cancel_policies]").prop('files')[0] !=undefined?$("input[name=upload_cancel_policies]").prop('files')[0]:"");
    $.ajax({
        url:site_url+"/admin/property/rental-polices-store",
        type:"POST",
        data: formData,
        dataType: "json",
        cache: false,
        contentType:false,
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