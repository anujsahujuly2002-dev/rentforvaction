let table;
$(function () {
    table = $("#reviews-table").DataTable({
        language: {
            zeroRecords: "No record(s) found.",
            searchPlaceholder: "Search records",
        },
        bDestroy: true,
        ordering: false,
        paging: true,
        processing: true,
        serverSide: true,
        searchable: false,
        bStateSave: true,
        bPaginate: false,
        bFilter: false,
        bInfo: false,
        scrollX: true,
        bLengthChange: false,
        ajax: {
            url: site_url + "/owner/property/get-reviews",
            data: function (d) {
                d.property_id = $("input[name=property_id]").val();
            },
        },
        dataType: "html",
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                searching: false,
                orderable: false,
            },
            {
                data: "reviews_heading",
                name: "reviews_heading",
                orderable: false,
            },
            { data: "guest_name", name: "guest_name", orderable: false },
            { data: "place", name: "place", orderable: false },
            { data: "reviews", name: "reviews", orderable: false },
            { data: "rating", name: "rating", orderable: false },
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false,
            },
        ],
    });
});
propertyReviews.onsubmit = async (e) => {
    e.preventDefault();
    try {
        showloader();
        const response = await fetch(
            site_url + "/owner/property/reviews-store",
            {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                body: new FormData(propertyReviews),
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
        if (results.status == 500) {
            hideLoader();
            toastr.error(results.msg);
        }
        if (response.status == 422) {
            hideLoader();
            $("span").text("");
            for (let error in results.errors) {
                $("." + error).text(results.errors[error]);
            }
        }
        if (results.status == 200) {
            toastr.success(results.msg);
            $("span").text("");
            propertyReviews.reset();
            table.draw();
            hideLoader();
        }
    } catch (error) {
        hideLoader();
        toastr.error(error.message);
        console.log(error.message);
    }
};

propertyReviewsDelete = async (id) => {
    try {
        showloader();
        const response = await fetch(
            site_url + "/owner/property/delete-reviews",
            {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                body: JSON.stringify({
                    id: id,
                }),
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
        if (results.status == 500) {
            hideLoader();
            toastr.error(results.msg);
        }
        if (response.status == 422) {
            hideLoader();
            $("span").text("");
            for (let error in results.errors) {
                $("." + error).text(results.errors[error]);
            }
        }
        if (results.status == 200) {
            toastr.success(results.msg);
            $("span").text("");
            propertyReviews.reset();
            table.draw();
            hideLoader();
        }
    } catch (error) {
        hideLoader();
        toastr.error(error.message);
    }
};

$(".next-step").on("click", function () {
    showloader();
    toastr.success("Property Added Successfully Please wait redirecting");
    window.setTimeout(function () {
        window.location.href = site_url + "/owner/dashboard";
    }, 2000);
    hideLoader();
});

editPropertyReviews = async (id) => {
    try {
        showloader();
        const response = await fetch(
            site_url + "/owner/property/edit-property-reviews",
            {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                body: JSON.stringify({
                    id: id,
                }),
            }
        );
        const results = await response.json();
        if (response.status == 405) {
            hideLoader();
            toastr.error(response.statusText);
        }
        if (response.status == 404) {
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
        if (results.status == 200) {
            hideLoader();
            $("#editPropertyReviews").modal("show");
            for (let index in results.data) {
                if (index == "rating") {
                    $("#editPropertyReviewsFrom")
                        .find(
                            'select[name^="rating"] option[value="' +
                                results.data[index] +
                                '"]'
                        )
                        .attr("selected", "selected");
                } else {
                    $("#editPropertyReviewsFrom")
                        .find(`input[name=${index}]`)
                        .val(results.data[index]);
                }
            }
        }
    } catch (error) {
        hideLoader();
        toastr.error(error.message);
    }
};

editPropertyReviewsFrom.onsubmit = async (e) => {
    e.preventDefault();
    try {
        showloader();
        const response = await fetch(
            site_url + "/owner/property/update-property-reviews",
            {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                body: new FormData(editPropertyReviewsFrom),
            }
        );
        const results = await response.json();
        if (response.status == 405) {
            hideLoader();
            toastr.error(response.statusText);
        }
        if (response.status == 404) {
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
        if (results.status == 200) {
            hideLoader();
            $("#editPropertyReviews").modal("hide");
            toastr.success(results.msg);
            table.draw();
        }
    } catch (error) {
        hideLoader();
        toastr.error(error.message);
    }
};
