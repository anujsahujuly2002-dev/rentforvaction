ownerLogin.onsubmit = async (e) => {
    showloader();
    e.preventDefault();
    try {
        const response = await fetch(site_url + "/owner/check-login", {
            method: "POST",
            body: new FormData(ownerLogin),
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        const result = await response.json();
        console.log(result);
        if (result.status == 422) {
            hideLoader();
            $("span").text("");
            for (let error in result.errors) {
                console.log(result.errors[error]);
                $("." + error).text(result.errors[error]);
            }
        } else if (result.status == 401) {
            hideLoader();
            toastr.error(result.msg);
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
    }
};
