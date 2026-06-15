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
            { data: "DT_RowIndex",      name: "DT_RowIndex",      searchable: false, orderable: false },
            { data: "name",             name: "name",             orderable: false,  searchable: true  },
            { data: "email",            name: "email",            orderable: false,  searchable: true  },
            { data: "total_properties", name: "total_properties", orderable: false,  searchable: false },
            { data: "is_approved",      name: "is_approved",      orderable: false,  searchable: false },
            { data: "action",           name: "action",           orderable: false,  searchable: false },
        ],
    });

    // ── Approve / Revoke Approval ──────────────────────────────────────────────
    $(document).on("click", ".toggle-approve-owner", function () {
        let id       = $(this).data("id");
        let approved = parseInt($(this).data("approved"));
        let name     = $(this).data("name");

        let isApproving = approved !== 1;
        let title   = isApproving ? "Approve Owner?" : "Revoke Approval?";
        let text    = isApproving
            ? name + " will be able to log in and manage their listings."
            : name + " will no longer be able to log in until re-approved.";
        let btnText  = isApproving ? "Yes, Approve" : "Yes, Revoke";
        let icon     = isApproving ? "question" : "warning";
        let btnColor = isApproving ? "#28a745" : "#e74c3c";

        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: btnColor,
            cancelButtonColor: "#6c757d",
            confirmButtonText: btnText,
            cancelButtonText: "Cancel",
        }).then(function (result) {
            if (!result.isConfirmed) return;

            $.ajax({
                url: site_url + "/admin/owner/toggle-approve",
                method: "POST",
                data: { id: id, _token: $('meta[name="csrf-token"]').attr("content") },
                success: function (res) {
                    if (res.status === 200) {
                        Swal.fire({ title: "Done!", text: res.msg, icon: "success", timer: 1800, showConfirmButton: false });
                        table.ajax.reload(null, false);
                    }
                },
                error: function () {
                    Swal.fire("Error", "Something went wrong. Please try again.", "error");
                },
            });
        });
    });

    // ── Delete Owner ───────────────────────────────────────────────────────────
    $(document).on("click", ".delete-owner", function () {
        let id   = $(this).data("id");
        let name = $(this).data("name");

        Swal.fire({
            title: "Delete Owner?",
            text: "This will permanently delete " + name + ". This action cannot be undone.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#e74c3c",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, Delete",
            cancelButtonText: "Cancel",
        }).then(function (result) {
            if (!result.isConfirmed) return;

            $.ajax({
                url: site_url + "/admin/owner/delete",
                method: "POST",
                data: { id: id, _token: $('meta[name="csrf-token"]').attr("content") },
                success: function (res) {
                    if (res.status === 200) {
                        Swal.fire({ title: "Deleted!", text: res.msg, icon: "success", timer: 1800, showConfirmButton: false });
                        table.ajax.reload(null, false);
                    } else {
                        Swal.fire("Cannot Delete", res.msg, "error");
                    }
                },
                error: function () {
                    Swal.fire("Error", "Something went wrong. Please try again.", "error");
                },
            });
        });
    });
});
