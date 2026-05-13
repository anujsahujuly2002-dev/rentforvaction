let table;

$(function () {
    $(document).on("change", ".start_date", function () {
        $(this).closest("form").find(".end_date").attr("min", $(this).val());
    });
    try {
        table = $("#rental-rates").DataTable({
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
                url: site_url + "/owner/property/get-property-rates",
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
                    data: "session_name",
                    name: "session_name",
                    orderable: false,
                },
                { data: "start_date", name: "start_date", orderable: false },
                { data: "end_date", name: "end_date", orderable: false },
                {
                    data: "nightly_rate",
                    name: "nightly_rate",
                    orderable: false,
                },
                {
                    data: "weekend_rate",
                    name: "weekend_rate",
                    orderable: false,
                },
                { data: "weekly_rate", name: "weekly_rate", orderable: false },
                {
                    data: "monthly_rate",
                    name: "monthly_rate",
                    orderable: false,
                },
                {
                    data: "minimum_stay",
                    name: "minimum_stay",
                    orderable: false,
                },
                {
                    data: "action",
                    name: "action",
                    orderable: false,
                    searchable: false,
                },
            ],
        });
    } catch (error) {
        console.log(error.message);
    }
});

rentalRates.onsubmit = async (e) => {
    e.preventDefault();
    try {
        showloader();
        const response = await fetch(
            site_url + "/owner/property/rental-rates-store",
            {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                body: new FormData(rentalRates),
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
        /* if (response.status == 422) {
            hideLoader();
            $("span").text("");
            for (let error in response.errors) {
                $("." + error + "-error").text(response.errors[error]);
            }
        } */
        if (results.status == 200) {
            rentalRates.reset();
            toastr.success(results.msg);
            hideLoader();
            table.draw();
        }
    } catch (error) {
        hideLoader();
        console.log(error.message);
    }
};

addMoreRates.onsubmit = async (e) => {
    e.preventDefault();
    try {
        showloader();
        const response = await fetch(
            site_url + "/owner/property/add-more-rental-rates",
            {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                body: new FormData(addMoreRates),
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
        if (response.status == 422) {
            hideLoader();
            $("span").text("");
            for (let error in results.errors) {
                $("." + error).text(results.errors[error]);
            }
        }
        if (results.status == 200) {
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

deleteRentalRates = async (id) => {
    showloader();
    let formData = new FormData();
    formData.append("id", id);
    let response = await fetch(
        site_url + "/owner/property/delete-property-rates",
        {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        }
    );
    const results = await response.json();
    console.log(results);
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
        toastr.success(results.msg);
        table.draw();
        hideLoader();
    }
};

editRentalRates = async (id) => {
    try {
        showloader();
        const response = await fetch(
            site_url + "/owner/property/edit-rental-rates",
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
            $("#rentalRatesModel").modal("show");
            for (let index in results.data) {
                $("#editRentalRatesFrom")
                    .find(`input[name=${index}]`)
                    .val(results.data[index]);
            }
        }
    } catch (error) {
        hideLoader();
        console.log(error.message);
        toastr.error(error.message);
    }
};

editRentalRatesFrom.onsubmit = async (e) => {
    e.preventDefault(e);
    try {
        showloader();
        const response = await fetch(
            site_url + "/owner/property/update-rental-rates",
            {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                body: new FormData(editRentalRatesFrom),
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
            toastr.success(results.msg);
            $("#rentalRatesModel").modal("hide");
            table.draw();
        }
    } catch (error) {
        hideLoader();
        toastr.error(error.message);
    }
};
