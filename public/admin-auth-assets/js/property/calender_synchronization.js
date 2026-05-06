// FullCalendar instance
var bookingCalendar = null;
var bookingData = [];

function initBookingCalendar() {
    var propertyId = $("input[name=property_id]").val();
    var calendarEl = document.getElementById("booking-calendar");

    if (!calendarEl || !propertyId) return;

    // Fetch bookings first, then build calendar
    $.ajax({
        url: site_url + "/admin/property/get-property-bookings",
        type: "GET",
        data: { property_id: propertyId },
        dataType: "json",
        success: function (res) {
            $("#stat-total").text(res.total || 0);
            $("#stat-upcoming").text(res.upcoming || 0);
            $("#stat-past").text(res.past || 0);
            bookingData = res.events || [];
            renderCalendar(calendarEl);
            renderBookingsList(bookingData);
        },
        error: function () {
            bookingData = [];
            renderCalendar(calendarEl);
            renderBookingsList([]);
        },
    });
}

function renderCalendar(calendarEl) {
    if (bookingCalendar) {
        bookingCalendar.destroy();
    }

    // Build lookup: date -> { booked, checkin, checkout, color, title }
    var dayMap = buildDayMap(bookingData);

    bookingCalendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "dayGridMonth",
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,dayGridWeek",
        },
        height: "auto",
        fixedWeekCount: false,
        dayCellDidMount: function (arg) {
            var dateStr = toDateStr(arg.date);
            var info = dayMap[dateStr];
            if (!info) return;

            var cell = arg.el;
            var isCheckin = info.checkin;
            var isCheckout = info.checkout;
            var isMiddle = info.booked && !isCheckin && !isCheckout;

            // Remove old classes
            cell.classList.remove('fc-day-booked-upcoming', 'fc-day-booked-current', 'fc-day-booked-past',
                'fc-day-checkin', 'fc-day-checkout');

            if (isMiddle) {
                // Full colored cell for middle days
                cell.classList.add(getBookedClass(info.color));
            }

            if (isCheckin && isCheckout) {
                // Same day: both triangles
                cell.classList.add('fc-day-checkin', 'fc-day-checkout');
            } else if (isCheckin) {
                cell.classList.add('fc-day-checkin');
            } else if (isCheckout) {
                cell.classList.add('fc-day-checkout');
            }

            // Tooltip
            if (info.titles && info.titles.length) {
                cell.title = info.titles.join(' | ');
            }
        },
    });

    bookingCalendar.render();
}

function buildDayMap(events) {
    var map = {};

    events.forEach(function (evt) {
        var start = new Date(evt.start);
        var end = new Date(evt.end);
        var color = evt.color || '#696cff';
        var title = evt.title || 'Booked';

        // end date in FullCalendar is exclusive, so last booked night is end - 1
        // Check-in = start date, Check-out = end date
        var checkinStr = toDateStr(start);
        var checkoutStr = toDateStr(end);

        // Mark check-in day
        if (!map[checkinStr]) map[checkinStr] = { booked: false, checkin: false, checkout: false, titles: [] };
        map[checkinStr].checkin = true;
        map[checkinStr].checkinColor = color;
        map[checkinStr].color = map[checkinStr].color || color;
        map[checkinStr].titles.push('Check-in: ' + title);

        // Mark check-out day
        if (!map[checkoutStr]) map[checkoutStr] = { booked: false, checkin: false, checkout: false, titles: [] };
        map[checkoutStr].checkout = true;
        map[checkoutStr].checkoutColor = color;
        map[checkoutStr].color = map[checkoutStr].color || color;
        map[checkoutStr].titles.push('Check-out: ' + title);

        // Mark middle days (between check-in+1 and check-out-1) as fully booked
        var cur = new Date(start);
        cur.setDate(cur.getDate() + 1);
        while (cur < end) {
            var ds = toDateStr(cur);
            if (!map[ds]) map[ds] = { booked: false, checkin: false, checkout: false, titles: [] };
            map[ds].booked = true;
            map[ds].color = color;
            map[ds].titles.push(title);
            cur.setDate(cur.getDate() + 1);
        }
    });

    return map;
}

function getBookedClass(color) {
    if (color === '#03c3ec') return 'fc-day-booked-current';
    if (color === '#8592ad') return 'fc-day-booked-past';
    return 'fc-day-booked-upcoming';
}

function toDateStr(date) {
    var d = new Date(date);
    var y = d.getFullYear();
    var m = ('0' + (d.getMonth() + 1)).slice(-2);
    var dd = ('0' + d.getDate()).slice(-2);
    return y + '-' + m + '-' + dd;
}

function formatDate(date) {
    if (!date) return "";
    var d = new Date(date);
    var months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
    return months[d.getMonth()] + " " + d.getDate() + ", " + d.getFullYear();
}

function refreshBookingCalendar() {
    initBookingCalendar();
}

function renderBookingsList(events) {
    // Destroy existing DataTable instance if any
    if ($.fn.DataTable.isDataTable('#bookings-list-table')) {
        $('#bookings-list-table').DataTable().destroy();
    }

    var tbody = $("#bookings-list-table tbody");
    tbody.empty();

    var today = toDateStr(new Date());
    events.forEach(function (evt, i) {
        var status = '';
        if (evt.end < today) {
            status = '<span class="badge bg-secondary">Past</span>';
        } else if (evt.start <= today && evt.end >= today) {
            status = '<span class="badge bg-info">Current</span>';
        } else {
            status = '<span class="badge bg-primary">Upcoming</span>';
        }
        tbody.append(
            '<tr>' +
                '<td>' + (i + 1) + '</td>' +
                '<td>' + (evt.title || 'Booked') + '</td>' +
                '<td data-order="' + evt.start + '">' + formatDate(new Date(evt.start)) + '</td>' +
                '<td data-order="' + evt.end + '">' + formatDate(new Date(evt.end)) + '</td>' +
                '<td>' + status + '</td>' +
                '<td><button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteBooking(' + evt.id + ')"><i class="bx bx-trash"></i></button></td>' +
            '</tr>'
        );
    });

    // Initialize DataTable
    $('#bookings-list-table').DataTable({
        ordering: true,
        order: [[2, 'desc']],
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        language: {
            emptyTable: "No bookings found.",
            zeroRecords: "No matching bookings found."
        },
        columnDefs: [
            { orderable: false, targets: [5] }
        ]
    });
}

// Initialize calendar when step-7 becomes visible
$(document).on("click", 'div.setup-panel div a[href="#step-7"]', function () {
    setTimeout(function () {
        initBookingCalendar();
    }, 200);
});

$(".sync_now").on("click", function (e) {
    e.preventDefault();
    showLoader();
    $.ajax({
        url: site_url + "/admin/property/calender-synchronization",
        type: "POST",
        data: {
            property_id: $("input[name=property_id]").val(),
            ical_link: $("input[name=import_calender_url]").val(),
        },
        dataType: "json",
        cache: false,
        success: (res) => {
            if (res.status == "1") {
                hideLoader();
                showToaster("bg-success", "top-0 end-0", res.msg);
                refreshBookingCalendar();
            } else {
                hideLoader();
                showToaster("bg-danger", "top-0 end-0", res.msg);
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

$(".calender_syncronization").on("click", function (e) {
    var curStep = $(this).closest(".setup-content"),
        curStepBtn = curStep.attr("id"),
        nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]')
            .parent()
            .next()
            .children("a");
    e.preventDefault();
    nextStepWizard.removeAttr("disabled").trigger("click");
});

exportIcalLink = async (id) => {
    showLoader();
    if (id != "") {
        const response = await fetch(site_url + "/property/ical-link/" + id);
        const result = await response.json();
        if (result.status == 200) {
            hideLoader();
            showToaster("bg-success", "top-0 end-0", result.msg);
            $(".copy_text").removeClass("d-none");

            $(".copy_text").attr("href", result.url);
        } else {
            hideLoader();
            showToaster("bg-danger", "top-0 end-0", "Internal Server Error");
        }
    } else {
        hideLoader();
        showToaster("bg-danger", "top-0 end-0", "Not Able to Export Link");
    }
};

$(".copy_text").click(function (e) {
    e.preventDefault();
    var copyText = $(this).attr("href");

    document.addEventListener(
        "copy",
        function (e) {
            e.clipboardData.setData("text/plain", copyText);
            e.preventDefault();
        },
        true
    );

    document.execCommand("copy");
    // console.log("copied text : ", copyText);
    showToaster("bg-success", "top-0 end-0", "Ical Link Copied");
});

// Manual Booking Form Submit
var checkinPicker = null;
var checkoutPicker = null;

// Build array of booked date ranges from bookingData for flatpickr disable
// Check-in picker: block start to end-1 (checkout day is available for new check-in)
function getCheckinDisabledFn() {
    return function (date) {
        var dateStr = toDateStr(date);
        for (var i = 0; i < bookingData.length; i++) {
            var evt = bookingData[i];
            // Disable if date >= booking start AND date < booking end
            // Checkout day (evt.end) stays enabled for new check-in
            if (dateStr >= evt.start && dateStr < evt.end) {
                return true;
            }
        }
        return false;
    };
}

// Check-out picker: block day after start to day before end (interior days only)
function getCheckoutDisabledFn() {
    return function (date) {
        var dateStr = toDateStr(date);
        for (var i = 0; i < bookingData.length; i++) {
            var evt = bookingData[i];
            // Disable if date > booking start AND date < booking end (middle days)
            if (dateStr > evt.start && dateStr < evt.end) {
                return true;
            }
        }
        return false;
    };
}

// Find the next available checkout date after a given checkin date
function getMaxCheckoutDate(checkinDate) {
    var checkin = new Date(checkinDate);
    var nearest = null;
    bookingData.forEach(function (evt) {
        var start = new Date(evt.start);
        // If booking starts after checkin, it limits checkout
        if (start > checkin) {
            if (!nearest || start < nearest) {
                nearest = start;
            }
        }
    });
    return nearest;
}

function initBookingDatepickers() {
    // Destroy existing pickers to refresh disabled dates
    if (checkinPicker) { checkinPicker.destroy(); checkinPicker = null; }
    if (checkoutPicker) { checkoutPicker.destroy(); checkoutPicker = null; }

    var today = new Date();
    today.setHours(0, 0, 0, 0);

    checkinPicker = flatpickr("#booking_start_date", {
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "M d, Y",
        minDate: "today",
        disableMobile: true,
        disable: [getCheckinDisabledFn()],
        onChange: function (selectedDates) {
            if (selectedDates.length > 0) {
                var checkinDate = selectedDates[0];
                var nextDay = new Date(checkinDate);
                nextDay.setDate(nextDay.getDate() + 1);

                // Find the nearest booked start date after checkin to limit checkout
                var maxDate = getMaxCheckoutDate(checkinDate);

                checkoutPicker.set("minDate", nextDay);
                if (maxDate) {
                    checkoutPicker.set("maxDate", maxDate);
                } else {
                    checkoutPicker.set("maxDate", null);
                }

                // Auto-set checkout to checkin + 1 night
                checkoutPicker.setDate(nextDay, true);
            }
        }
    });

    checkoutPicker = flatpickr("#booking_end_date", {
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "M d, Y",
        minDate: new Date(today.getTime() + 86400000),
        disableMobile: true,
        disable: [getCheckoutDisabledFn()],
    });
}

// Initialize datepickers when modal opens
$(document).on("shown.bs.modal", "#manual-booking-modal", function () {
    initBookingDatepickers();
});

$("#manualBookingForm").on("submit", function (e) {
    e.preventDefault();
    var propertyId = $("input[name=property_id]").val();

    // Clear previous errors
    $(".booking_guest_name-error").html("");
    $(".booking_start_date-error").html("");
    $(".booking_end_date-error").html("");

    var guestName = $("#booking_guest_name").val();
    var startDate = $("#booking_start_date").val();
    var endDate = $("#booking_end_date").val();

    // Client-side validation
    var hasError = false;
    if (!guestName || guestName.trim() === "") {
        $(".booking_guest_name-error").html("Guest name is required.");
        hasError = true;
    }
    if (!startDate) {
        $(".booking_start_date-error").html("Check-in date is required.");
        hasError = true;
    }
    if (!endDate) {
        $(".booking_end_date-error").html("Check-out date is required.");
        hasError = true;
    }
    if (startDate && endDate && startDate >= endDate) {
        $(".booking_end_date-error").html("Check-out must be after check-in.");
        hasError = true;
    }
    // Check overlap with existing bookings
    // In vacation rentals: new check-in CAN be on same day as existing check-out
    // So overlap = new start < existing end AND new end > existing start
    // But allow: new start == existing end (same-day turnover)
    if (startDate && endDate && !hasError) {
        for (var i = 0; i < bookingData.length; i++) {
            var evt = bookingData[i];
            // New check-in on existing checkout day is allowed
            // New checkout on existing checkin day is allowed
            var existingStart = evt.start;
            var existingEnd = evt.end;
            // Overlap only if ranges truly intersect (excluding same-day turnovers)
            if (startDate < existingEnd && endDate > existingStart && startDate !== existingEnd && endDate !== existingStart) {
                Swal.fire({
                    icon: 'error',
                    title: 'Date Overlap',
                    text: 'Selected dates overlap with an existing booking (' + evt.title + ': ' + evt.start + ' to ' + evt.end + ').',
                    confirmButtonColor: '#7367f0',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                });
                hasError = true;
                break;
            }
        }
    }
    if (!propertyId) {
        showToaster("bg-danger", "top-0 end-0", "Please save property first before adding bookings.");
        hasError = true;
    }
    if (hasError) return;

    showLoader();
    $.ajax({
        url: site_url + "/admin/property/manual-booking-store",
        type: "POST",
        data: {
            property_id: propertyId,
            booking_guest_name: guestName,
            booking_start_date: startDate,
            booking_end_date: endDate,
        },
        dataType: "json",
        success: function (res) {
            hideLoader();
            if (res.status == "1") {
                showToaster("bg-success", "top-0 end-0", res.msg);
                $("#manual-booking-modal").modal("hide");
                $("#manualBookingForm")[0].reset();
                // Destroy flatpickr instances – they'll reinit with updated disabled dates on next modal open
                if (checkinPicker) { checkinPicker.destroy(); checkinPicker = null; }
                if (checkoutPicker) { checkoutPicker.destroy(); checkoutPicker = null; }
                refreshBookingCalendar();
            } else {
                showToaster("bg-danger", "top-0 end-0", res.msg);
            }
        },
        error: function (xhr) {
            hideLoader();
            if (xhr.status == 422) {
                var errors = xhr.responseJSON.errors;
                if (errors.booking_guest_name) $(".booking_guest_name-error").html(errors.booking_guest_name[0]);
                if (errors.booking_start_date) $(".booking_start_date-error").html(errors.booking_start_date[0]);
                if (errors.booking_end_date) $(".booking_end_date-error").html(errors.booking_end_date[0]);
            } else {
                showToaster("bg-danger", "top-0 end-0", xhr.responseJSON.message || "Something went wrong.");
            }
        },
    });
});

// Delete Booking
function deleteBooking(bookingId) {
    Swal.fire({
        title: 'Delete Booking?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ea5455',
        cancelButtonColor: '#82868b',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        allowOutsideClick: false,
        allowEscapeKey: false,
        customClass: {
            confirmButton: 'btn btn-danger me-2',
            cancelButton: 'btn btn-secondary'
        },
        buttonsStyling: false
    }).then(function (result) {
        if (result.isConfirmed) {
            showLoader();
            $.ajax({
                url: site_url + "/admin/property/delete-booking",
                type: "POST",
                data: { booking_id: bookingId },
                dataType: "json",
                success: function (res) {
                    hideLoader();
                    if (res.status == "1") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: res.msg,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        refreshBookingCalendar();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: res.msg,
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        });
                    }
                },
                error: function (xhr) {
                    hideLoader();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON.message || "Something went wrong.",
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });
                },
            });
        }
    });
}
