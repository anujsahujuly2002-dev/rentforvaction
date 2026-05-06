logout = async () => {
    showloader();
    try {
        const response = await fetch(site_url + "/owner/logout");
        const result = await response.json();
        if (result.status == 200) {
            toastr.success(result.msg);
            window.setTimeout(() => {
                hideLoader();
                window.location.href = result.url;
            }, 2000);
        } else {
            hideLoader();
            toastr.error(result.msg);
        }
    } catch (error) {
        hideLoader();
        toastr.error(error.message);
    }
};
