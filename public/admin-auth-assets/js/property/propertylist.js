let table;
$(function () {
    table = $("#property-listing").DataTable({
        language: {
            zeroRecords: "No record(s) found.",
            searchPlaceholder: "Search records",
        },
        bDestroy: true,
        searching: true,
        ordering: false,
        paging: true,
        processing: true,
        serverSide: true,
        lengthChange: true,
        bSearchable: true,
        bStateSave: true,
        scrollX: true,
        ajax: {
            url: site_url + "/admin/property",
        },
        dataType: "html",
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                searching: false,
                orderable: false,
            },
            { data: "id", name: "id", orderable: true, searchable: true },
            { data: "property_name", name: "property_name", orderable: false },
            { data: "", name: "", orderable: false, defaultContent: 0 },
            {
                data: "subscription_date",
                name: "subscription_date",
                orderable: false,
                defaultContent: "13 july 2023",
                searchable: false,
            },
            { data: "created_date", name: "created_date", orderable: false },
            {
                data: "renewal_date",
                name: "renewal_date",
                orderable: false,
                defaultContent: "13 July 2024",
            },
            { data: "", name: "", orderable: false, defaultContent: 0 },
            {
                data: "property_main_photos",
                name: "property_main_photos",
                orderable: false,
                searchable: false,
            },
            {
                data: "property_approved",
                name: "property_approved",
                orderable: false,
            },
            {
                data: "featured_property",
                name: "featured_property",
                orderable: false,
            },
            {
                data: "is_recommended",
                name: "is_recommended",
                orderable: false,
            },
            { data: "action", name: "action", orderable: false },
        ],
    });
    $.fn.dataTable.ext.errMode = "none";
    $("#permission").on("error.dt", function (e, settings, techNote, message) {
        console.log("An error has been reported by DataTables: ", message);
    });
    $(".menu-item").on("click", function () {
        try {
            table.state.clear();
        } catch (err) {
            console.log(err.message);
        }
    });
    $(".search").on("click", function () {
        table.draw();
    });
});

function featured_property(id, status) {
    showLoader();
    $.ajax({
        url: site_url + "/admin/property/add-featured-property",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: { id: id, status: status },
        cache: false,
        success: (res) => {
            if ((res.status = 200)) {
                hideLoader();
                showToaster("bg-success", "top-0 end-0", res.msg);
                table.draw();
            }
        },
        error(xhr, ajaxOptions, thrownError) {
            hideLoader();
            showToaster("bg-danger", "top-0 end-0", xhr.responseJSON.message);
        },
    });
}

function approvedProperty(id, status) {
    showLoader();
    $.ajax({
        url: site_url + "/admin/property/property-approved",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: { id: id, status: status },
        cache: false,
        success: (res) => {
            if ((res.status = 200)) {
                hideLoader();
                showToaster("bg-success", "top-0 end-0", res.msg);
                table.draw();
            }
        },
        error(xhr, ajaxOptions, thrownError) {
            hideLoader();
            showToaster("bg-danger", "top-0 end-0", xhr.responseJSON.message);
        },
    });
}

function addRecommendation(id, status) {
    showLoader();
    $.ajax({
        url: site_url + "/admin/property/add-recommendation",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: { id: id, status: status },
        cache: false,
        success: (res) => {
            if ((res.status = 200)) {
                hideLoader();
                showToaster("bg-success", "top-0 end-0", res.msg);
                table.draw();
            }
        },
        error(xhr, ajaxOptions, thrownError) {
            hideLoader();
            showToaster("bg-danger", "top-0 end-0", xhr.responseJSON.message);
        },
    });
}

async function deleteProperty(id) {
    try {
        const result = await Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        });

        if (result.isConfirmed) {
            showLoader();
            $.ajax({
                url: site_url + "/admin/property/delete-property",
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                data: {
                    id: id,
                },
                dataType: "json",
                cache: false,
                success: (res) => {
                    if (res.status === 200) {
                        hideLoader();
                        Swal.fire("Deleted!", res.msg, "danger");
                        table.draw();
                    } else {
                        hideLoader();
                        Swal.fire("Error!", res.msg, "danger");
                    }
                },
            });
        }
    } catch (error) {
        // Handle errors
        console.error(error);
    }
}
