var descriptionEditor;
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
function initDescriptionEditor() {
    if (descriptionEditor) return;
    var el = document.querySelector("#description");
    if (!el) return;
    // Delay creation to ensure the container is fully visible and rendered
    setTimeout(function() {
        ClassicEditor.create(el)
        .then((editor) => {
            descriptionEditor = editor;
        })
        .catch((error) => {
            console.error(error);
        });
    }, 300);
}

$(".property_information").on("click", function (e) {
    e.preventDefault();
    showLoader();
    var selected = [];
    $("#property_suitablity :selected").each(function () {
        selected.push($(this).val());
    });
    var curStep = $(this).closest(".setup-content"),
    curStepBtn = curStep.attr("id"),
    nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a");
    var formData = new FormData();
    formData.append("property_id", $("input[name='property_id']").val());
    formData.append("property_name", $("input[name=property_name]").val());
    formData.append("property_suitablity", selected);
    formData.append("property_main_image",$("#property_main_image").prop("files")[0] != undefined? $("#property_main_image").prop("files")[0]: "");
    formData.append("property_old_image", $("input[name=property_old_image]").val());
    formData.append("square_feet", $("input[name=square_feet]").val());
    formData.append("property_type", $("select[name=property_type]").val());
    formData.append("bedrooms", $("select[name=bedrooms]").val());
    formData.append("sleeps", $("input[name=sleeps]").val());
    formData.append("avg_night", $("input[name=avg_night]").val());
    formData.append("rate_per_unit", $("select[name=rate_per_unit]").val());
    formData.append("baths", $("select[name=baths]").val());
    formData.append("description", descriptionEditor.getData());
    formData.append("country_name", $("select[name=country_name]").val());
    formData.append("state_name", $("select[name=state_name]").val());
    formData.append("region_name", $("select[name=region_name]").val());
    formData.append("city_name", $("select[name=city_name]").val());
    formData.append("sub_city", $("select[name=sub_city]").val());
    formData.append(
        "external_website_link",
        $("input[name=external_website_link]").val()
    );
    formData.append(
        "personal_website_link",
        $("input[name=personal_website_link]").val()
    );

    $.ajax({
        url: site_url + "/admin/property/property-information",
        type: "POST",
        contentType: "multipart/form-data",
        cache: false,
        contentType: false,
        processData: false,
        data: formData,
        success: (res) => {
            console.log(res);
            if (res.status == "1") {
                hideLoader();
                $("input[name='property_id']").val(res.property_id);
                nextStepWizard.removeAttr("disabled").trigger("click");
            }
        },
        error(xhr, ajaxOptions, thrownError) {
            hideLoader();
            let errors = xhr.responseJSON.errors;
            console.log(errors);
            if (xhr.status == "422") {
                $("span").text("");
                for (let error in errors) {
                    console.log(errors[error]);
                    $("." + error + "-error").text(errors[error]);
                }
            } else if (xhr.status == "401") {
                console;
                let error = xhr.responseJSON;
                showToaster("bg-danger", "top-0 end-0", error.msg);
            } else {
                showToaster(
                    "bg-danger",
                    "top-0 end-0",
                    xhr.responseJSON.message
                );
            }
        },
    });
});
