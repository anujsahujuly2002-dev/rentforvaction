propertyDescription.onsubmit = async (e) => {
    e.preventDefault(e);
    showloader();
    try {
        // Sync CKEditor 5 content back into the <textarea name="description">
        // before FormData reads it, otherwise the textarea stays empty and the
        // server-side `description: required` rule rejects the request.
        if (typeof descriptionEditor !== "undefined" && descriptionEditor) {
            document.querySelector("#description").value =
                descriptionEditor.getData();
        }
        res = await fetch(
            site_url + "/owner/property/store-property-information",
            {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                body: new FormData(propertyDescription),
            }
        );

        const response = await res.json();
        if (res.status == 405) {
            hideLoader();
            toastr.error(res.statusText);
        }
        if (res.status == 419) {
            hideLoader();
            toastr.error(res.statusText);
        }
        if (res.status == 500) {
            hideLoader();
            toastr.error(res.statusText);
        }
        if (res.status == 422) {
            hideLoader();
            $("span").text("");
            for (let error in response.errors) {
                $("." + error + "-error").text(response.errors[error]);
            }
        }
        if (res.status == 200) {
            toastr.success(response.msg);
            window.setTimeout(function () {
                window.location.href = response.url;
            }, 2000);
            hideLoader();
        }
    } catch (error) {
        hideLoader();
        console.log(error.message);
    }
};
