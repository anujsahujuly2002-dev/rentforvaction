@extends('frontend.layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend-assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .enquiry-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            padding: 30px;
        }
        .enquiry-card .form-label {
            font-weight: 500;
            color: #444;
        }
        .enquiry-card input.form-control,
        .enquiry-card select.form-control,
        .enquiry-card textarea.form-control {
            border-radius: 6px;
        }
    </style>
@endpush
@push('div_start')
<div class="innerheader">
@endpush
@push('div_end')
</div>
@endpush
@section('content')

    <div class="dashboard-wrappermy pt-5">
        <div class="container">
            <div class="das-title">Property Information</div>
            @include('owner.layouts.owner-navbar')

            <div class="property-mainsection">
                <div class="row">
                    @include('owner.property.left-sidebar')
                    <div class="col-md-10">
                        <div class="small-title">Send Enquiry</div>
                        <div class="add-listing-section">
                            <div class="with-forms">
                                <div id="enquiry-alert" style="display:none;" class="alert mb-3"></div>
                                <form id="ownerEnquiryForm">
                                    @csrf
                                    <input type="hidden" name="property_id" value="{{ request()->id }}">
                                    <div class="enquiry-card">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                                <input type="text" name="first_name" class="form-control" placeholder="First Name">
                                                <small class="text-danger error-first_name"></small>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                                <input type="text" name="last_name" class="form-control" placeholder="Last Name">
                                                <small class="text-danger error-last_name"></small>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Phone <span class="text-danger">*</span></label>
                                                <input type="tel" name="phone" class="form-control" placeholder="Phone Number">
                                                <small class="text-danger error-phone"></small>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                                <input type="email" name="email" class="form-control" placeholder="Email Address">
                                                <small class="text-danger error-email"></small>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Check In</label>
                                                <input type="text" name="checkin" id="enquiry-checkin" class="form-control" placeholder="Arrival date" autocomplete="off" readonly>
                                                <small class="text-danger error-checkin"></small>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Check Out</label>
                                                <input type="text" name="checkout" id="enquiry-checkout" class="form-control" placeholder="Departure date" autocomplete="off" readonly>
                                                <small class="text-danger error-checkout"></small>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Adults</label>
                                                <select name="adults" class="form-control">
                                                    <option value="0">Select Adults</option>
                                                    @for($i = 1; $i <= 10; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Children</label>
                                                <select name="children" class="form-control">
                                                    <option value="0">Select Children</option>
                                                    @for($i = 1; $i <= 10; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label">Message</label>
                                                <textarea name="message" class="form-control" rows="4" placeholder="Write your message here..."></textarea>
                                                <small class="text-danger error-message"></small>
                                            </div>
                                            <div class="col-md-12">
                                                <button type="submit" id="enquirySubmitBtn" class="button preview">
                                                    Send Enquiry <i class="fa fa-paper-plane-o ms-1"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
$(function () {
    var checkinPicker = flatpickr('#enquiry-checkin', {
        dateFormat: 'Y-m-d',
        minDate: 'today',
        onChange: function (selectedDates) {
            if (selectedDates.length) {
                checkoutPicker.set('minDate', selectedDates[0]);
            }
        }
    });

    var checkoutPicker = flatpickr('#enquiry-checkout', {
        dateFormat: 'Y-m-d',
        minDate: 'today',
    });

    $('#ownerEnquiryForm').on('submit', function (e) {
        e.preventDefault();

        var $btn = $('#enquirySubmitBtn');
        $btn.prop('disabled', true).text('Sending...');
        $('small[class^="error-"]').text('');
        $('#enquiry-alert').hide().removeClass('alert-success alert-danger');

        showloader();

        $.ajax({
            url: site_url + '/owner/property/submit-enquiry',
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: $(this).serialize(),
            success: function (res) {
                hideLoader();
                $btn.prop('disabled', false).html('Send Enquiry <i class="fa fa-paper-plane-o ms-1"></i>');
                if (res.status === 200) {
                    toastr.success(res.msg);
                    $('#enquiry-alert')
                        .removeClass('alert-danger').addClass('alert-success alert show')
                        .text(res.msg).show();
                    $('#ownerEnquiryForm')[0].reset();
                    checkinPicker.clear();
                    checkoutPicker.clear();
                } else {
                    toastr.error(res.msg);
                }
            },
            error: function (xhr) {
                hideLoader();
                $btn.prop('disabled', false).html('Send Enquiry <i class="fa fa-paper-plane-o ms-1"></i>');
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function (field, messages) {
                        $('small.error-' + field).text(messages[0]);
                    });
                } else {
                    toastr.error('Something went wrong. Please try again.');
                }
            }
        });
    });
});
</script>
@endpush
