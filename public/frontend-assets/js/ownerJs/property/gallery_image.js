let images = [];
function image_select() {
    let image = document.getElementById("property-gallery-image").files;

    for (var i = 0; i < image.length; i++) {
        if (check_dublicate(image[i].name)) {
            images.push({
                name: image[i].name,
                url: URL.createObjectURL(image[i]),
                file: image[i],
            });
        } else {
            alert(image[i].name + " has been already Uploaded");
        }
    }
    //    $("#container").html();
    document.getElementById("container").innerHTML = image_show();
}

function image_show() {
    var img = "";
    images.forEach((i) => {
        img += `<div class="image_container d-flex justify-content-center position-relative">
        <img src="${i.url}" alt="Image" srcset="">
        <span class="position-absolute" onclick=delete_image(${images.indexOf(
            i
        )})>&times;</span>
        </div>`;
    });
    return img;
}

function delete_image(e) {
    images.splice(e, 1);
    document.getElementById("container").innerHTML = image_show();
}

function check_dublicate(name) {
    var dublicate_image = true;
    for (i = 0; i < images.length; i++) {
        if (images[i].name == name) {
            dublicate_image = false;
            break;
        }
    }
    return dublicate_image;
}

galleryImage.onsubmit = async (e) => {
    try {
        showloader();
        e.preventDefault();
        var formData = new FormData();
        formData.append("property_id", $("input[name=property_id]").val());
        formData.append("type", $("input[name=type]").val() ?? "");
        formData.append("totalFiles", images.length);
        for (i = 0; i < images.length; i++) {
            console.log(images[i].file);
            formData.append("files" + i, images[i].file);
        }
        const response = await fetch(
            site_url + "/owner/property/gallery-image-store",
            {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    // "Content-Type": "application/json",
                },
                body: formData,
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
        if (response.status == 422) {
            hideLoader();
            $("span").text("");
            for (let error in results.errors) {
                $("." + error).text(results.errors[error]);
            }
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
