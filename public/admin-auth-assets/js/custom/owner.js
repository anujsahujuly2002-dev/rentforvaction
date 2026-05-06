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
        bSearchable: true,
        bStateSave: true,
        scrollX: true,
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
            { data: "total_properties", name: "total_properties", orderable: false, searchable: true },
            { data: "type", name: "type", orderable: false, searchable: true },
            { data: "action", name: "action", orderable: false },
        ],
    });
});
