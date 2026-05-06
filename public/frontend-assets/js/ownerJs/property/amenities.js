amenitiesProperties.onsubmit = async (e) => {
    e.preventDefault();
    showloader();
    try {
        res = await fetch(site_url + "/owner/property/aminites-properties", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            body: new FormData(amenitiesProperties),
        });

        const result = await res.json();
        console.log(result);
        console.log(res);
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

        if (result.status == 200) {
            toastr.success(result.msg);
            window.setTimeout(function () {
                window.location.href = result.url;
            }, 2000);
            hideLoader();
        }
    } catch (error) {
        hideLoader();
        console.log(error.message);
    }
};
