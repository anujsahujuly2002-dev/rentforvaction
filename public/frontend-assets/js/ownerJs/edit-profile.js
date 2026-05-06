myProfile.onsubmit = async (e) => {
    e.preventDefault();
    showloader();
    try {
        const response = await fetch(site_url + "/owner/edit-profile", {
            method: "POST",
            body: new FormData(myProfile),
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        const result = await response.json();
        if (result.status == 200) {
            hideLoader();
            // load("#my-profile");
            toastr.success(result.msg);
        } else {
            hideLoader();
            toastr.error(result.msg);
        }
    } catch (error) {
        hideLoader();
        toastr.error(error.message);
    }
};

profilePhoto.onsubmit = async (e) => {
    showloader();
    e.preventDefault(e);
    try {
        const response = await fetch(site_url + "/owner/profile-photo", {
            method: "POST",
            body: new FormData(profilePhoto),
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        const result = await response.json();
        if (result.status == 200) {
            toastr.success(result.msg);
            hideLoader();
            window.location.reload();
        } else {
            toastr.error(result.msg);
            hideLoader();
        }
    } catch (error) {
        hideLoader();
        toastr.error(error.message);
    }
};

ownerAddress.onsubmit = async (e) => {
    e.preventDefault();
    showloader();
    try {
        const response = await fetch(site_url + "/owner/owner-address", {
            method: "POST",
            body: new FormData(ownerAddress),
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        const result = await response.json();
        if (result.status == 200) {
            hideLoader();
            toastr.success(result.msg);
        } else {
            hideLoader();
            toastr.error(result.msg);
        }
    } catch (error) {
        hideLoader();
        toastr.error(error.message);
    }
};

changePassword.onsubmit = async (e) => {
    e.preventDefault();
    showloader();
    try {
        const response = await fetch(site_url + "/owner/change-password", {
            method: "POST",
            body: new FormData(changePassword),
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
        } else if (result.status == 200) {
            hideLoader();
            toastr.success(result.msg);
            window.setTimeout(function () {
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
