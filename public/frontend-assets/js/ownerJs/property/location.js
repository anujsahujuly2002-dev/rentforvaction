propertyLocation.onsubmit = async (e) => {
    e.preventDefault(e);
    try {
        showloader();
        const response = await fetch(
            site_url + "/owner/property/location-store",
            {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                body: new FormData(propertyLocation),
            }
        );
        const result = await response.json();
        
        if (response.status == 405) {
            hideLoader();
            toastr.error(response.statusText);
        }
        if (response.status == 419) {
            hideLoader();
            toastr.error(response.statusText);
        }
        if (response.status == 500) {
            hideLoader();
            toastr.error(response.statusText);
        }
        if (response.status == 200) {
            toastr.success(result.msg);
            window.setTimeout(function () {
                window.location.href = result.url;
            }, 2000);
            hideLoader();
        }
    } catch (error) {
        hideLoader();
        console.log(error.meassge);
    }
};
