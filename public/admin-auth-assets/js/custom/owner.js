$(function () {
    let table = $("#owner").DataTable({
        language: {
            zeroRecords: "No record(s) found.",
            searchPlaceholder: "Search records",
        },
        ajax: {
            url: site_url + "/admin/owner",
        },
        bDestroy: true,
        searching: true,
        ordering: false,
        paging: true,
        processing: true,
        serverSide: true,
        lengthChange: true,
        scrollX: true,
        columns: [
            { data: "DT_RowIndex", name: "DT_RowIndex", searchable: false, orderable: false },
            { data: "name", name: "name", orderable: false, searchable: true },
            { data: "email", name: "email", orderable: false, searchable: true },
            { data: "total_properties", name: "total_properties", orderable: false, searchable: false },
            { data: "is_approved", name: "is_approved", orderable: false, searchable: false },
            { data: "status", name: "status", orderable: false, searchable: false },
            { data: "action", name: "action", orderable: false, searchable: false },
        ],
    });

    $(document).on("click", ".approve-owner", function () {
        let id = $(this).data("id");
        if (!confirm("Approve this owner account?")) return;
        $.ajax({
            url: site_url + "/admin/owner/approve",
            method: "POST",
            data: { id: id, _token: $('meta[name="csrf-token"]').attr("content") },
            success: function (res) {
                if (res.status === 200) {
                    toastr.success(res.msg);
                    table.ajax.reload(null, false);
                }
            },
            error: function () {
                toastr.error("Something went wrong.");
            },
        });
    });

    $(document).on("click", ".toggle-block-owner", function () {
        let id     = $(this).data("id");
        let status = $(this).data("status");
        let label  = status == 1 ? "unblock" : "block";
        if (!confirm("Are you sure you want to " + label + " this owner?")) return;
        $.ajax({
            url: site_url + "/admin/owner/toggle-block",
            method: "POST",
            data: { id: id, _token: $('meta[name="csrf-token"]').attr("content") },
            success: function (res) {
                if (res.status === 200) {
                    toastr.success(res.msg);
                    table.ajax.reload(null, false);
                }
            },
            error: function () {
                toastr.error("Something went wrong.");
            },
        });
    });
});
