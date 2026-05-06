propertyRentalPolicies.onsubmit = async (e) => {
    e.preventDefault();
    try {
        showloader();
        const response = await fetch(
            site_url + "/owner/property/rental-polices-store",
            {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                body: new FormData(propertyRentalPolicies),
            }
        );
        const results = await response.json();

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
        /*  if (response.status == 422) {
            hideLoader();
            $("span").text("");
            for (let error in results.errors) {
                $("." + error).text(results.errors[error]);
            }
        } */

        if (results.status == 200) {
            toastr.success(results.msg);
            window.setTimeout(function () {
                window.location.href = results.url;
            }, 2000);
            hideLoader();
        }
    } catch (error) {
        hideLoader();
        console.log(error.message);
    }
};
