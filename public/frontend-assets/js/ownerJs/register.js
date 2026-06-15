function refreshCaptcha() {
    const img = document.getElementById('captcha-image');
    if (img) img.src = site_url + '/captcha/flat?' + Date.now();
}

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
        if (result.status == 422) {
            hideLoader();
            $("span").text("");
            for (let error in result.errors) {
                $("." + error).text(result.errors[error]);
            }
            // Always refresh captcha after a failed attempt
            refreshCaptcha();
            ownerRegistration.querySelector('[name="captcha"]').value = '';
        } else if (result.status == 200) {
            toastr.success(result.msg);
            window.setTimeout(() => {
                hideLoader();
                window.location.href = result.url;
            }, 3000);
        } else {
            hideLoader();
            toastr.error(result.msg || 'Registration failed.');
        }
    } catch (error) {
        hideLoader();
        toastr.error(error.message);
    }
};
