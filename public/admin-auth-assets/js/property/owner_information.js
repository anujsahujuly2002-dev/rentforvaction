$(".owner_information").on("click",function(e){
    showLoader();
    e.preventDefault();
    let owner_information={
        "user_information_update":$("input[name=user_information_update]").val(),
        "property_id":$("input[name=property_id]").val(),
        "first_name":$("input[name=first_name]").val(),
        "last_name":$("input[name=last_name]").val(),
        "primary_email":$("input[name=primary_email]").val(),
        "secondary_email":$("input[name=secondary_email]").val(),
        "phone":$("input[name=phone]").val(),
        "alternate_phone":$("input[name=alternate_phone]").val(),
        "address":$("input[name=address]").val(),
        "city":$("input[name=city]").val(),
        "state":$("input[name=state]").val(),
        "year_purchased":$("input[name=year_purchased]").val(),
        "about_you":$("textarea[name=about_you]").val(),
    };

    $.ajax({
        url:site_url+"/admin/property/owner-information-store",
        type:"POST",
        data: owner_information,
        dataType: "json",
        cache: false,
        // contentType:false,
        // processData:false,
        success:(res)=>{
            if(res.status=='1'){
                hideLoader();
                showToaster("bg-success","top-0 end-0",res.msg);
                window.setTimeout(() => {
                    window.location.href=res.url; 
                }, 1000);
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
    });
});