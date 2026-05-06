$(" input.amenites[type=checkbox] ").on("click", function () {
    showLoader();
    let className;
    if ($(this).attr("data-level") == "subAmenities") {
        className = "description_" + $(this).val();
    } else {
        className = "description_per_" + $(this).val();
    }
    // alert($(this).attr('data-level'));
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: site_url + "/admin/property/check-aminites-description",
        type: "POST",
        data: { id: $(this).val(), type: $(this).attr("data-level") },
        cache: false,
        success: (res) => {
            hideLoader();
            if (res.data.description == 1) {
                let description = `<textarea  placeholder="Describe yourself here..." class="form-control h-150px" rows="2" name="description"> </textarea>`;
                if (this.checked) {
                    $("." + className).html(description);
                } else {
                    $("." + className).html("");
                }
            }
        },
    });
});

$(".amenities").on("click", function (e) {
    var curStep = $(this).closest(".setup-content"),
        curStepBtn = curStep.attr("id"),
        nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]')
            .parent()
            .next()
            .children("a");
    e.preventDefault();
    showLoader();
    let main_aminites = [];
    $("input.amenites[type=checkbox]").each(function () {
        if (this.checked) {
            if ($(this).attr("data-level") == "subAmenities") {
                className = "description_" + $(this).val();
            } else {
                className = "description_per_" + $(this).val();
            }
            var description = $("." + className)
                .find("textarea[name=description]")
                .val();
            main_aminites.push({
                property_id: $("input[name='property_id']").val(),
                id: $(this).val(),
                type: $(this).attr("data-level"),
                description: description != undefined ? description : "",
            });
        }
    });
    if (main_aminites.length == 0) {
        hideLoader();
        showToaster(
            "bg-danger",
            "top-0 end-0",
            "Please Select at least one amenities"
        );
        return false;
    } else {
        console.log(main_aminites);
        $.ajax({
            url: site_url + "/admin/property/aminites-store",
            type: "POST",
            data: { amenites: main_aminites },
            dataType: "json",
            cache: false,
            success: (res) => {
                if (res.status == "1") {
                    hideLoader();
                    nextStepWizard.removeAttr("disabled").trigger("click");
                }
            },
            error(xhr, ajaxOptions, thrownError) {
                hideLoader();
                showToaster(
                    "bg-danger",
                    "top-0 end-0",
                    xhr.responseJSON.message
                );
            },
        });
    }
});
