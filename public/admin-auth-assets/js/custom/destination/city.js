let table;
$(function () {
    table = $("#city").DataTable({
        language: {
            zeroRecords: "No record(s) found.",
            searchPlaceholder: "Search records",
        },
        ajax: {
            url: site_url + "/admin/destination/city",
        },
        bDestroy: true,
        searching: true,
        ordering: false,
        paging: true,
        processing: true,
        serverSide: true,
        bSearchable: true,
        bStateSave: true,
        bPaginate: false,
        bFilter: false,
        bInfo: false,
        scrollX: true,
        bLengthChange: false,
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                searchable: false,
                orderable: false,
            },
            { data: "country_name", name: "country_name", orderable: false, searchable: true },
            { data: "state_name", name: "state_name", orderable: false, searchable: true },
            { data: "region_name", name: "region_name", orderable: false, searchable: true },
            { data: "name", name: "name", orderable: false, searchable: true },
            { data: "action", name: "action", orderable: false },
        ],
    });
    $.fn.dataTable.ext.errMode = "none";
    $("#city").on("error.dt", function (e, settings, techNote, message) {
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

$("#city-create").on("submit", function (e) {
    e.preventDefault();
    showLoader();
    $.ajax({
        url: site_url + "/admin/destination/city/store",
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
                $(this).find(".country_name-error").html("");
                $(this).find(".state_name-error").html("");
                $(this).find(".region_name-error").html("");
                $(this).find(".city_name-error").html("");
                let error = xhr.responseJSON.errors;
                $(this)
                    .find(".country_name-error")
                    .append(
                        `<span class="text-danger">${error.country_name}</span>`
                    );
                $(this)
                    .find(".state_name-error")
                    .append(
                        `<span class="text-danger">${error.state_name}</span>`
                    );
                $(this)
                    .find(".region_name-error")
                    .append(
                        `<span class="text-danger">${error.region_name}</span>`
                    );
                $(this)
                    .find(".city_name-error")
                    .append(
                        `<span class="text-danger">${error.city_name}</span>`
                    );
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

$("#city-edit").on("submit", function (e) {
    e.preventDefault();
    showLoader();
    $.ajax({
        url: site_url + "/admin/destination/city/update",
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
                $(this).find(".country_name-error").html("");
                $(this).find(".state_name-error").html("");
                $(this).find(".region_name-error").html("");
                let error = xhr.responseJSON.errors;
                $(this)
                    .find(".country_name-error")
                    .append(
                        `<span class="text-danger">${error.country_name}</span>`
                    );
                $(this)
                    .find(".state_name-error")
                    .append(
                        `<span class="text-danger">${error.state_name}</span>`
                    );
                $(this)
                    .find(".region_name-error")
                    .append(
                        `<span class="text-danger">${error.region_name}</span>`
                    );
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

function deleteCity(id) {
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
                url: site_url + "/admin/destination/city/delete",
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
                error: (xhr, ajaxOptions, thrownError) => {
                    hideLoader();
                    if (xhr.status == "401") {
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
        }
    });
}
