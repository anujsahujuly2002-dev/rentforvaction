ownerRegistration.onsubmit = async (e) => {
    showloader();
    e.preventDefault();
    try {
        const response = await fetch(site_url + "/owner/register-store", {
            method: "POST",
            body: new FormData(ownerRegistration),
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        const result = await response.json();
        console.log(result.status);
        if (result.status == 422) {
            hideLoader();
            console.log(result.errors);
            $("span").text("");
            for (let error in result.errors) {
                console.log(result.errors[error]);
                $("." + error).text(result.errors[error]);
            }
        } else if (result.status == 200) {
            toastr.success(result.msg);
            window.setTimeout(() => {
                hideLoader();
                window.location.href = result.url;
            }, 2000);
        }
    } catch (error) {
        hideLoader();
        toastr.error(error.message);
        console.log(error.message);
    }
};
