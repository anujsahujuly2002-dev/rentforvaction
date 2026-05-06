propertyCalender.onsubmit = async (e) => {
    e.preventDefault();
    try {
        showloader();
        const response = await fetch(
            site_url + "/owner/property/calender-syncronization",
            {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                body: new FormData(propertyCalender),
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
            // window.setTimeout(function () {
            //     window.location.href = results.url;
            // }, 2000);
            hideLoader();
        }
    } catch (error) {
        hideLoader();
        console.log(error.message);
    }
};

$(".next-step").on("click", function () {
    showloader();
    window.setTimeout(function () {
        window.location.href =
            site_url +
            "/owner/property/reviews?id=" +
            $("input[name=property_id]").val() +
            "&type=edit";
    }, 2000);
});

exportIcalLink = async (id) => {
    showloader();

    if (id != undefined) {
        const response = await fetch(site_url + "/property/ical-link/" + id);
        const result = await response.json();
        if (result.status == 200) {
            hideLoader();
            toastr.success(result.msg);
            $(".copy_text").removeAttr("style");

            $(".copy_text").attr("href", result.url);
        } else {
            hideLoader();
            toastr.error("Internal Server Error");
        }
    } else {
        hideLoader();
        toastr.error("Not Able to Export Link");
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
    toastr.success("Ical Link Copied");
});

// =====================================================
// Booking Calendar (FullCalendar + Manual Booking)
// =====================================================
var bookingCalendar = null;
var bookingData = [];

function initBookingCalendar() {
    var propertyId = $("input[name=property_id]").val();
    var calendarEl = document.getElementById("booking-calendar");

    if (!calendarEl || !propertyId) return;

    $.ajax({
        url: site_url + "/owner/property/get-property-bookings",
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

            cell.classList.remove('fc-day-booked-upcoming', 'fc-day-booked-current', 'fc-day-booked-past',
                'fc-day-checkin', 'fc-day-checkout');

            if (isMiddle) {
                cell.classList.add(getBookedClass(info.color));
            }

            if (isCheckin && isCheckout) {
                cell.classList.add('fc-day-checkin', 'fc-day-checkout');
            } else if (isCheckin) {
                cell.classList.add('fc-day-checkin');
            } else if (isCheckout) {
                cell.classList.add('fc-day-checkout');
            }

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

        var checkinStr = toDateStr(start);
        var checkoutStr = toDateStr(end);

        if (!map[checkinStr]) map[checkinStr] = { booked: false, checkin: false, checkout: false, titles: [] };
        map[checkinStr].checkin = true;
        map[checkinStr].checkinColor = color;
        map[checkinStr].color = map[checkinStr].color || color;
        map[checkinStr].titles.push('Check-in: ' + title);

        if (!map[checkoutStr]) map[checkoutStr] = { booked: false, checkin: false, checkout: false, titles: [] };
        map[checkoutStr].checkout = true;
        map[checkoutStr].checkoutColor = color;
        map[checkoutStr].color = map[checkoutStr].color || color;
        map[checkoutStr].titles.push('Check-out: ' + title);

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
                '<td><button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteBooking(' + evt.id + ')"><i class="fa fa-trash-o"></i></button></td>' +
            '</tr>'
        );
    });

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

// Initialize calendar on page load
$(document).ready(function () {
    setTimeout(function () {
        initBookingCalendar();
    }, 300);
});

// Manual Booking Datepickers
var checkinPicker = null;
var checkoutPicker = null;

function getCheckinDisabledFn() {
    return function (date) {
        var dateStr = toDateStr(date);
        for (var i = 0; i < bookingData.length; i++) {
            var evt = bookingData[i];
            if (dateStr >= evt.start && dateStr < evt.end) {
                return true;
            }
        }
        return false;
    };
}

function getCheckoutDisabledFn() {
    return function (date) {
        var dateStr = toDateStr(date);
        for (var i = 0; i < bookingData.length; i++) {
            var evt = bookingData[i];
            if (dateStr > evt.start && dateStr < evt.end) {
                return true;
            }
        }
        return false;
    };
}

function getMaxCheckoutDate(checkinDate) {
    var checkin = new Date(checkinDate);
    var nearest = null;
    bookingData.forEach(function (evt) {
        var start = new Date(evt.start);
        if (start > checkin) {
            if (!nearest || start < nearest) {
                nearest = start;
            }
        }
    });
    return nearest;
}

function initBookingDatepickers() {
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

                var maxDate = getMaxCheckoutDate(checkinDate);

                checkoutPicker.set("minDate", nextDay);
                if (maxDate) {
                    checkoutPicker.set("maxDate", maxDate);
                } else {
                    checkoutPicker.set("maxDate", null);
                }

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

$(document).on("shown.bs.modal", "#manual-booking-modal", function () {
    initBookingDatepickers();
});

$("#manualBookingForm").on("submit", function (e) {
    e.preventDefault();
    var propertyId = $("input[name=property_id]").val();

    $(".booking_guest_name-error").html("");
    $(".booking_start_date-error").html("");
    $(".booking_end_date-error").html("");

    var guestName = $("#booking_guest_name").val();
    var startDate = $("#booking_start_date").val();
    var endDate = $("#booking_end_date").val();

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
    if (startDate && endDate && !hasError) {
        for (var i = 0; i < bookingData.length; i++) {
            var evt = bookingData[i];
            var existingStart = evt.start;
            var existingEnd = evt.end;
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
        toastr.error("Please save property first before adding bookings.");
        hasError = true;
    }
    if (hasError) return;

    showloader();
    $.ajax({
        url: site_url + "/owner/property/manual-booking-store",
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
                toastr.success(res.msg);
                $("#manual-booking-modal").modal("hide");
                $("#manualBookingForm")[0].reset();
                if (checkinPicker) { checkinPicker.destroy(); checkinPicker = null; }
                if (checkoutPicker) { checkoutPicker.destroy(); checkoutPicker = null; }
                refreshBookingCalendar();
            } else {
                toastr.error(res.msg);
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
                toastr.error(xhr.responseJSON.message || "Something went wrong.");
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
            showloader();
            $.ajax({
                url: site_url + "/owner/property/delete-booking",
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
