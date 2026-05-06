@extends('frontend.layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend-assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css">
    <style>
        /* Calendar Wrapper */
        #booking-calendar-wrapper {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            padding: 20px;
            margin-top: 20px;
        }

        /* Stat Cards */
        .calendar-stats {
            display: flex;
            gap: 15px;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }
        .stat-card {
            flex: 1;
            min-width: 110px;
            background: linear-gradient(135deg, #696cff 0%, #8b8eff 100%);
            color: #fff;
            border-radius: 10px;
            padding: 16px 18px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(105,108,255,0.15);
        }
        .stat-card.stat-upcoming {
            background: linear-gradient(135deg, #03c3ec 0%, #41d4f0 100%);
            box-shadow: 0 2px 8px rgba(3,195,236,0.15);
        }
        .stat-card.stat-past {
            background: linear-gradient(135deg, #8592ad 0%, #a3aec4 100%);
            box-shadow: 0 2px 8px rgba(133,146,173,0.15);
        }
        .stat-number { font-size: 1.7rem; font-weight: 700; }
        .stat-label { font-size: 0.82rem; opacity: 0.85; margin-top: 2px; }

        /* FullCalendar Override */
        .fc { font-size: 0.95rem; }
        .fc .fc-toolbar-title { font-size: 1.15rem; font-weight: 600; color: #566a7f; }
        .fc .fc-button { font-size: 0.82rem; padding: 4px 12px; border-radius: 6px; }
        .fc .fc-button-primary { background-color: #696cff; border: none; }
        .fc .fc-button-primary:hover { background-color: #5f61e6; }
        .fc .fc-button-primary:disabled { background-color: #b4b5ff; }
        .fc .fc-button-primary:not(:disabled).fc-button-active { background-color: #5f61e6; }
        .fc .fc-daygrid-day { min-height: 60px; position: relative; }
        .fc .fc-col-header-cell-cushion { color: #566a7f; font-weight: 600; text-decoration: none; }
        .fc .fc-daygrid-day-number { font-size: 0.82rem; color: #697a8d; text-decoration: none; }

        /* Booked Day Colors */
        .fc-day-booked-upcoming {
            background-color: rgba(105, 108, 255, 0.22) !important;
        }
        .fc-day-booked-current {
            background-color: rgba(3, 195, 236, 0.22) !important;
        }
        .fc-day-booked-past {
            background-color: rgba(133, 146, 173, 0.18) !important;
        }

        /* Check-in triangle (bottom-right, green) */
        .fc-day-checkin {
            position: relative;
        }
        .fc-day-checkin::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top left, #28c76f 50%, transparent 50%);
            opacity: 0.35;
            pointer-events: none;
            z-index: 1;
        }

        /* Check-out triangle (top-left, orange) */
        .fc-day-checkout {
            position: relative;
        }
        .fc-day-checkout::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom right, #ff9f43 50%, transparent 50%);
            opacity: 0.35;
            pointer-events: none;
            z-index: 1;
        }

        /* Legend */
        .calendar-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            margin-top: 14px;
            padding: 10px 0;
        }
        .legend-item { display: flex; align-items: center; gap: 6px; font-size: 0.82rem; color: #566a7f; }
        .legend-dot { width: 14px; height: 14px; border-radius: 50%; display: inline-block; }
        .legend-triangle { width: 0; height: 0; display: inline-block; }
        .legend-triangle-checkin {
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-bottom: 14px solid #28c76f;
        }
        .legend-triangle-checkout {
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-top: 14px solid #ff9f43;
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
            {{-- <div class="propertyInfo">
                <div class="row">
                    <div class="col-md-2"><img src="images/gallery/1.jpg" alt=""></div>
                    <div class="col-md-10">
                        <h1>Oceanfront Luxury Villa, Recently Renovated! Family/Couple getaway</h1>
                        <p>Cancun, Quintana Roo, Mexico</p>
                    </div>
                </div>
            </div> --}}
            <div class="property-mainsection">
                <div class="row">
                    @include('owner.property.left-sidebar')
                    <div class="col-md-10">
                        <div class="small-title">Property Calender</div>
                        <div class="add-listing-section">
                            <div class="with-forms">
                                <form id="propertyCalender">
                                    <div class="row">
                                        <input type="hidden" name="property_id" value="{{ request()->id }}">
                                        <div class="col-md-9">
                                            <label for="import_calender_url">Import Calender Url</label>
                                            <input type="text" name="import_calender_url" class="form-control" id="import_calender_url" placeholder="Import Calender link" value="{{ $properties->ical_link??"" }}">
                                        </div>
                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-primary sync_now" style="margin: 36px;">Sync Now</button>
                                        </div>
                                        <div class="col-md-12">
                                            <a href="javascript:void(0)" class="btn btn-primary" onclick="exportIcalLink({{$properties->id??''}})">Export Calender (iCal File)</a>
                                            <a class="copy_text btn btn-primary"  data-toggle="tooltip" title="Copy to Clipboard" href="" style="display:none">Copy ical Link</a>
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#manual-booking-modal">
                                                <i class="fa fa-plus"></i> Add Manual Booking
                                            </button>
                                         </div>
                                    </div>
                                </form>

                                {{-- Booking Calendar Section --}}
                                <div class="col-md-12">
                                    <div id="booking-calendar-wrapper">
                                        <div class="calendar-stats" id="calendar-stats">
                                            <div class="stat-card">
                                                <div class="stat-number" id="stat-total">0</div>
                                                <div class="stat-label">Total Bookings</div>
                                            </div>
                                            <div class="stat-card stat-upcoming">
                                                <div class="stat-number" id="stat-upcoming">0</div>
                                                <div class="stat-label">Upcoming</div>
                                            </div>
                                            <div class="stat-card stat-past">
                                                <div class="stat-number" id="stat-past">0</div>
                                                <div class="stat-label">Past</div>
                                            </div>
                                        </div>
                                        <div id="booking-calendar"></div>
                                        <div class="calendar-legend">
                                            <div class="legend-item">
                                                <span class="legend-dot" style="background:#696cff;"></span> Upcoming Booking
                                            </div>
                                            <div class="legend-item">
                                                <span class="legend-dot" style="background:#03c3ec;"></span> Current Booking
                                            </div>
                                            <div class="legend-item">
                                                <span class="legend-dot" style="background:#8592ad;"></span> Past Booking
                                            </div>
                                            <div class="legend-item">
                                                <span class="legend-triangle legend-triangle-checkin"></span> Check-In
                                            </div>
                                            <div class="legend-item">
                                                <span class="legend-triangle legend-triangle-checkout"></span> Check-Out
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Booking List Table --}}
                                <div class="col-md-12 mt-3">
                                    <div id="bookings-list-wrapper" style="background:#fff; border-radius:10px; box-shadow:0 2px 12px rgba(0,0,0,0.08); padding:20px;">
                                        <h6 style="color:#566a7f; font-weight:600; margin-bottom:12px;">Booking List</h6>
                                        <div class="table-responsive">
                                            <table class="table table-sm" id="bookings-list-table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Guest / Event</th>
                                                        <th>Check-In</th>
                                                        <th>Check-Out</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <button class="button preview next-step">Save &amp; Continue <i class="fa fa-arrow-circle-right"></i></button>
                            </div>
                        </div>
                    </div>

            {{-- Manual Booking Modal --}}
            <div class="modal fade" id="manual-booking-modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Manual Booking</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="manualBookingForm">
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="booking_guest_name" class="form-label">Guest Name / Event</label>
                                        <input type="text" id="booking_guest_name" class="form-control" name="booking_guest_name" placeholder="e.g. John Smith or Reserved" />
                                        <span class="text-danger booking_guest_name-error"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="booking_start_date" class="form-label">Check-In Date</label>
                                        <input type="text" id="booking_start_date" class="form-control" name="booking_start_date" placeholder="Select check-in date" readonly />
                                        <span class="text-danger booking_start_date-error"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="booking_end_date" class="form-label">Check-Out Date</label>
                                        <input type="text" id="booking_end_date" class="form-control" name="booking_end_date" placeholder="Select check-out date" readonly />
                                        <span class="text-danger booking_end_date-error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Save Booking</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- Manual Booking Modal End --}}
                 </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('admin-auth-assets/js/swal.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('frontend-assets/js/ownerJs/property/calender.js') }}"></script>
@endpush
