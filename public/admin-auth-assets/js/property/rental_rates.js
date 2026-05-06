var ratesNotesDescription;
let property_rates_table;
$(function () {
    ClassicEditor.create(document.querySelector("#rates_notes"))
        .then((editor) => {
            ratesNotesDescription = editor;
        })
        .catch((error) => {
            console.error(error);
        });
    property_rates_table = $("#property_rates").DataTable({
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
            url: site_url + "/admin/property/get-property-rates",
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
            { data: "session_name", name: "session_name", orderable: false },
            { data: "start_date", name: "start_date", orderable: false },
            { data: "end_date", name: "end_date", orderable: false },
            { data: "nightly_rate", name: "nightly_rate", orderable: false },
            { data: "weekly_rate", name: "weekly_rate", orderable: false },
            { data: "weekend_rate", name: "weekend_rate", orderable: false },
            { data: "monthly_rate", name: "weekend_rate", orderable: false },
            { data: "minimum_stay", name: "minimum_stay", orderable: false },
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false,
            },
        ],
    });
    $.fn.dataTable.ext.errMode = "none";
    $("#property_rates").on(
        "error.dt",
        function (e, settings, techNote, message) {
            console.log("An error has been reported by DataTables: ", message);
        }
    );
    $(".mega-menu").on("click", function () {
        try {
            table.state.clear();
        } catch (err) {
            console.log(err.message);
        }
    });
});

$(".add_rates").on("click", function (e) {
    e.preventDefault();
    showLoader();
    let rates = {
        property_id: $("input[name=property_id]").val(),
        session_name: $("input[name=session_name]").val(),
        start_date: $("input[name=start_date]").val(),
        end_date: $("input[name=end_date]").val(),
        nightly_rate: $("input[name=nightly_rate]").val(),
        weekly_rate: $("input[name=weekly_rate]").val(),
        weekend_rate: $("input[name=weekend_rate]").val(),
        monthly_rate: $("input[name=monthly_rate]").val(),
        minimum_stay: $("input[name=minimum_stay]").val(),
    };
    $.ajax({
        url: site_url + "/admin/property/rates-store",
        type: "POST",
        data: rates,
        dataType: "json",
        cache: false,
        success: (res) => {
            if (res.status == "1") {
                $("input[name=session_name]").val(""),
                    $("input[name=start_date]").val(""),
                    $("input[name=end_date]").val(""),
                    $("input[name=nightly_rate]").val(""),
                    $("input[name=weekly_rate]").val(""),
                    $("input[name=weekend_rate]").val(""),
                    $("input[name=monthly_rate]").val(""),
                    $("input[name=minimum_stay]").val(""),
                    hideLoader();
                showToaster("bg-success", "top-0 end-0", res.msg);
                property_rates_table.draw();
            }
        },
        error(xhr, ajaxOptions, thrownError) {
            hideLoader();
            let error = xhr.responseJSON.errors;
            if (xhr.status == "422") {
                $(".session_name").html("");
                $(".from_date").html("");
                $(".end_date").html("");
                $(".minimum_stay").html("");

                $(".session_name").text(error.session_name);
                $(".from_date").text(error.start_date);
                $(".end_date").text(error.end_date);
                $(".minimum_stay").text(error.minimum_stay);
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

$(".rental_rates").on("click", function (e) {
    let pet_allowed = 0;
    let smoked_allowed = 0;
    if ($("#pet_allowed:checked").val() != undefined) {
        pet_allowed = 1;
    }
    if ($("#smoked_allowed:checked").val() != undefined) {
        smoked_allowed = 1;
    }
    e.preventDefault();
    showLoader();
    var curStep = $(this).closest(".setup-content"),
        curStepBtn = curStep.attr("id"),
        nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]')
            .parent()
            .next()
            .children("a");
    let rental_rates = {
        property_id: $("input[name=property_id]").val(),
        admin_fees: $("input[name=admin_fees]").val(),
        cleaning_fees: $("input[name=cleaning_fees]").val(),
        refundable_damage_deposite: $(
            "input[name=refundable_damage_deposite]"
        ).val(),
        danage_waiver: $("input[name=danage_waiver]").val(),
        pet_fee: $("input[name=pet_fee]").val(),
        pet_rate_per_unit: $("select[name=pet_rate_per_unit]").val(),
        extra_person_fee: $("input[name=extra_person_fee]").val(),
        after_guest: $("select[name=after_guest]").val(),
        poolheating_fee: $("input[name=poolheating_fee]").val(),
        pool_heating_fees_perday: $(
            "select[name=pool_heating_fees_perday]"
        ).val(),
        check_in: $("input[name=check_in]").val(),
        check_out: $("input[name=check_out]").val(),
        tax_rates: $("input[name=tax_rates]").val(),
        change_over: $("select[name=change_over]").val(),
        all_rates_are_in: $("select[name=all_rates_are_in]").val(),
        rates_notes: ratesNotesDescription.getData(),
        pet_allowed: pet_allowed,
        smoked_allowed: smoked_allowed,
    };

    $.ajax({
        url: site_url + "/admin/property/rental-rates-store",
        type: "POST",
        data: rental_rates,
        dataType: "json",
        cache: false,
        success: (res) => {
            if (res.status == "1") {
                hideLoader();
                nextStepWizard.removeAttr("disabled").trigger("click");
            }
        },
        error(xhr, ajaxOptions, thrownError) {
            hideLoader();
            let error = xhr.responseJSON.errors;
            if (xhr.status == "422") {
                $(".all_rates_are_in").html("");
                $(".all_rates_are_in").html(error.all_rates_are_in);
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

function editRentalRates(id) {
    showLoader();
    $.ajax({
        url: site_url + "/admin/property/get-rental-rates-by-id",
        type: "POST",
        data: { id: id },
        cache: false,
        success: (res) => {
            hideLoader();
            if (res.status == "1") {
                $("#edit-rental-rates").modal("show");
                let form = $("#editrentalrate");
                form.find("input[name=id]").val(res.data.id);
                form.find("input[name=session_name]").val(
                    res.data.session_name
                );
                form.find("input[name=start_date]").val(res.data.start_date);
                form.find("input[name=end_date]").val(res.data.end_date);
                form.find("input[name=nightly_rate]").val(
                    res.data.nightly_rate
                );
                form.find("input[name=weekly_rate]").val(res.data.weekly_rate);
                form.find("input[name=weekend_rate]").val(
                    res.data.weekend_rate
                );
                form.find("input[name=monthly_rate]").val(
                    res.data.monthly_rate
                );
                form.find("input[name=minimum_stay]").val(
                    res.data.minimum_stay
                );
            }
        },
        error(xhr, ajaxOptions, thrownError) {},
    });
}

// $("#edit-rental-rate").on("submit",function(){

// });
editrentalrate.onsubmit = async (e) => {
    showLoader();
    e.preventDefault();
    let response = await fetch(
        site_url + "/admin/property/rentals-rates-update",
        {
            method: "POST",
            body: new FormData(editrentalrate),
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        }
    );
    let result = await response.json();
    if (result.status == 200) {
        $("#edit-rental-rates").modal("hide");
        hideLoader();
        showToaster("bg-success", "top-0 end-0", result.msg);
        property_rates_table.draw();
    } else {
        hideLoader();
        showToaster("bg-danger", "top-0 end-0", result.msg);
    }
};

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
            $.ajax({
                url: site_url + "/admin/property/delete-rental-rates",
                type: "POST",
                data: {
                    id: id,
                },
                dataType: "json",
                cache: false,
                success: (res) => {
                    if (res.status === 200) {
                        hideLoader();
                        Swal.fire("Deleted!", res.msg, "danger");
                        property_rates_table.draw();
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
