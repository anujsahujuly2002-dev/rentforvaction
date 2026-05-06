let table;
$(function () {
    table = $("#staff").DataTable({
        language: {
            zeroRecords: "No record(s) found.",
            searchPlaceholder: "Search records",
        },
        ajax: {
            url: site_url + "/admin/staff",
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
        dataType: "html",
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                searchable: false,
                orderable: false,
            },
            { data: "name", name: "name", orderable: false, searchable: true },
            { data: "email", name: "email", orderable: false, searchable: true },
            { data: "role", name: "role", orderable: false, searchable: true },
            { data: "action", name: "action", orderable: false },
        ],
    });
    $.fn.dataTable.ext.errMode = "none";
    $("#staff").on("error.dt", function (e, settings, techNote, message) {
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

$("#staff-create").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
        url: site_url + "/admin/staff/store",
        type: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: (res) => {
            hideLoader();
            showToaster("bg-success", "top-0 end-0", res.msg);
            window.setTimeout(() => {
                window.location.href = res.url;
            }, 1000);
        },
        error: (xhr, ajaxOptions, thrownError) => {
            hideLoader();
            if (xhr.status == "422") {
                $(this).find(".role-name-error").html("");
                let error = xhr.responseJSON.errors;
                $(this)
                    .find(".name-error")
                    .append(`<span class="text-danger">${error.name}</span>`);
                $(this)
                    .find(".email-error")
                    .append(`<span class="text-danger">${error.email}</span>`);
                $(this)
                    .find(".role-error")
                    .append(`<span class="text-danger">${error.role}</span>`);
            }
            if (xhr.status == "401") {
                console;
                let error = xhr.responseJSON;
                showToaster("bg-danger", "top-0 end-0", error.msg);
            } else {
                showToaster(
                    "bg-danger",
                    "top-0 end-0",
                    xhr.responseJSON.message
                );
            }
        },
    });
});

$("#staff-edit").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
        url: site_url + "/admin/staff/update",
        type: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: (res) => {
            hideLoader();
            showToaster("bg-success", "top-0 end-0", res.msg);
            window.setTimeout(() => {
                window.location.href = res.url;
            }, 1000);
        },
        error: (xhr, ajaxOptions, thrownError) => {
            hideLoader();
            if (xhr.status == "422") {
                $(this).find(".role-name-error").html("");
                let error = xhr.responseJSON.errors;
                $(this)
                    .find(".name-error")
                    .append(`<span class="text-danger">${error.name}</span>`);
                $(this)
                    .find(".email-error")
                    .append(`<span class="text-danger">${error.email}</span>`);
                $(this)
                    .find(".role-error")
                    .append(`<span class="text-danger">${error.role}</span>`);
            }
            if (xhr.status == "401") {
                console;
                let error = xhr.responseJSON;
                showToaster("bg-danger", "top-0 end-0", error.msg);
            } else {
                showToaster(
                    "bg-danger",
                    "top-0 end-0",
                    xhr.responseJSON.message
                );
            }
        },
    });
});

function deleteStaff(id) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            showLoader();
            $.ajax({
                url: site_url + "/admin/staff/delete",
                type: "POST",
                dataType: "json",
                data: { id: id },
                cache: false,
                success: function (res) {
                    // hideLoader();
                    showToaster("bg-success", "top-0 end-0", res.msg);
                    window.setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                },
            });
        }
    });
}
