@extends('admin.layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend-assets/css/chosen.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css">
    <style>
        .image_container {
            height: 120px;
            width: 150px;
            border-radius: 6px;
            overflow: hidden;
            margin: 10px;
        }

        .image_container img {
            height: 100%;
            width: auto;
            object-fit: cover;
        }

        .image_container span {
            top: -6px;
            right: 10px;
            color: red;
            font-size: 28px;
            font-weight: normal;
            cursor: pointer;
        }

        .stepwizard-step .btn-circle {
            width: auto;
            height: auto;
            border-radius: 5px;
            padding: 5px 15px;
            font-size: 12px;
            background: #f5f5f5;
        }

        .stepwizard-step span {
            display: block;
        }

        .stepwizard-step .btn-primary {
            background-color: #696cff !important;
            color: #fff !important;
        }

        .padnone .dataTables_scrollBody {
            overflow: inherit !important;
        }

        #listing_form {
            margin-top: 20px;
        }

        .padnone .dataTables_wrapper {
            padding: 0px;
            letter-spacing: 0px !important;
        }

        .padnone .table th {
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: inherit;

        }

        .padnone .table td {
            font-size: 12px;
            padding: 10px 0px;
        }

        #property_reviews_wrapper table {
            width: 100% !important;
        }

        #property_reviews_wrapper .dataTables_scrollHeadInner {
            width: 100% !important;
        }

        /* FullCalendar Custom Styles */
        #booking-calendar-wrapper {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            padding: 20px;
            margin-top: 20px;
        }
        #booking-calendar-wrapper .fc {
            font-family: 'Public Sans', sans-serif;
        }
        #booking-calendar-wrapper .fc .fc-toolbar-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #566a7f;
        }
        #booking-calendar-wrapper .fc .fc-button {
            background-color: #696cff;
            border-color: #696cff;
            font-size: 0.8125rem;
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            text-transform: capitalize;
        }
        #booking-calendar-wrapper .fc .fc-button:hover {
            background-color: #5f61e6;
            border-color: #5f61e6;
        }
        #booking-calendar-wrapper .fc .fc-button-active,
        #booking-calendar-wrapper .fc .fc-button:active {
            background-color: #5f61e6 !important;
            border-color: #5f61e6 !important;
        }
        #booking-calendar-wrapper .fc .fc-daygrid-day-number {
            font-size: 0.8125rem;
            padding: 6px 10px;
            position: relative;
            z-index: 2;
        }
        #booking-calendar-wrapper .fc .fc-col-header-cell-cushion {
            font-size: 0.75rem;
            font-weight: 600;
            color: #697a8d;
            text-transform: uppercase;
            padding: 8px;
        }
        #booking-calendar-wrapper .fc td,
        #booking-calendar-wrapper .fc th {
            border-color: #e9ecee;
        }
        #booking-calendar-wrapper .fc .fc-daygrid-day {
            position: relative;
            overflow: hidden;
        }
        #booking-calendar-wrapper .fc .fc-daygrid-day.fc-day-today {
            background-color: rgba(105, 108, 255, 0.06);
        }
        /* Hide default events rendering - we use cell background instead */
        #booking-calendar-wrapper .fc .fc-daygrid-day-events {
            display: none;
        }
        /* Full booked day - entire cell colored */
        .fc-day-booked-upcoming {
            background-color: #696cff !important;
        }
        .fc-day-booked-upcoming .fc-daygrid-day-number,
        .fc-day-booked-upcoming .fc-daygrid-day-top { color: #fff !important; }
        .fc-day-booked-current {
            background-color: #03c3ec !important;
        }
        .fc-day-booked-current .fc-daygrid-day-number,
        .fc-day-booked-current .fc-daygrid-day-top { color: #fff !important; }
        .fc-day-booked-past {
            background-color: #8592ad !important;
        }
        .fc-day-booked-past .fc-daygrid-day-number,
        .fc-day-booked-past .fc-daygrid-day-top { color: #fff !important; }
        /* Check-in day: triangle bottom-right half (green) */
        .fc-day-checkin::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top left, #28c76f 50%, transparent 50%);
            z-index: 1;
            pointer-events: none;
        }
        .fc-day-checkin .fc-daygrid-day-number,
        .fc-day-checkin .fc-daygrid-day-top { position: relative; z-index: 2; }
        /* Check-out day: triangle top-left half (orange) */
        .fc-day-checkout::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom right, #ff9f43 50%, transparent 50%);
            z-index: 1;
            pointer-events: none;
        }
        .fc-day-checkout .fc-daygrid-day-number,
        .fc-day-checkout .fc-daygrid-day-top { position: relative; z-index: 2; color: #fff !important; }
        /* Both check-in and check-out on same day */
        .fc-day-checkin.fc-day-checkout::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom right, #ff9f43 50%, transparent 50%);
            z-index: 1;
            pointer-events: none;
        }
        .fc-day-checkin.fc-day-checkout::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top left, #28c76f 50%, transparent 50%);
            z-index: 1;
            pointer-events: none;
        }
        .fc-day-checkin.fc-day-checkout .fc-daygrid-day-number,
        .fc-day-checkin.fc-day-checkout .fc-daygrid-day-top { position: relative; z-index: 2; color: #566a7f !important; }
        .calendar-legend {
            display: flex;
            gap: 18px;
            margin-top: 14px;
            flex-wrap: wrap;
            align-items: center;
        }
        .calendar-legend .legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.8125rem;
            color: #566a7f;
        }
        .calendar-legend .legend-dot {
            width: 14px;
            height: 14px;
            border-radius: 3px;
            display: inline-block;
        }
        .calendar-legend .legend-triangle {
            width: 14px;
            height: 14px;
            display: inline-block;
            position: relative;
            overflow: hidden;
            border-radius: 2px;
            border: 1px solid #e2e5e9;
        }
        .legend-triangle-checkin::after {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: linear-gradient(to top left, #28c76f 50%, transparent 50%);
        }
        .legend-triangle-checkout::after {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: linear-gradient(to bottom right, #ff9f43 50%, transparent 50%);
        }
        .calendar-stats {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }
        .calendar-stats .stat-card {
            background: linear-gradient(135deg, #696cff 0%, #8592ff 100%);
            color: #fff;
            border-radius: 8px;
            padding: 12px 20px;
            min-width: 140px;
            text-align: center;
        }
        .calendar-stats .stat-card.stat-upcoming {
            background: linear-gradient(135deg, #03c3ec 0%, #71d8f7 100%);
        }
        .calendar-stats .stat-card.stat-past {
            background: linear-gradient(135deg, #8592ad 0%, #a1acbf 100%);
        }
        .calendar-stats .stat-card .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1;
        }
        .calendar-stats .stat-card .stat-label {
            font-size: 0.75rem;
            opacity: 0.85;
            margin-top: 2px;
        }
    </style>

    @if (!empty($property))
        <style>
            .stepwizard a {
                pointer-events: auto;
            }
        </style>
    @endif
@endpush
@section('title')
    Property Create
@endsection
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('toaster.toaster')
        <div class="row">
            <div class="col-md-6">
                <h4 class="fw-bold py-3 mb-4">Property Create</h4>
            </div>
            <div class="col-md-6">
                <a href="{{ route('admin.property.index') }}" class="btn btn-primary text-right" style="float: right">Back</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="stepwizard col-md-offset-3">
                            <div class="stepwizard-row setup-panel">
                                <div class="stepwizard-step">
                                    <a href="#step-1" type="button" class="btn btn-primary btn-circle"><small>1</small>
                                        <span>Property Information</span></a>
                                </div>
                                <div class="stepwizard-step">
                                    <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled
                                        aria-disabled="true"><small>2</small> <span>Amenities & Attraction</span></a>
                                </div>
                                <div class="stepwizard-step">
                                    <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled
                                        aria-disabled="true"><small>3</small> <span>Location Info</span></a>
                                </div>
                                <div class="stepwizard-step">
                                    <a href="#step-4" type="button" class="btn btn-default btn-circle" disabled
                                        aria-disabled="true"><small>4</small> <span>Rental Rates</span></a>

                                </div>
                                <div class="stepwizard-step">
                                    <a href="#step-5" type="button" class="btn btn-default btn-circle" disabled
                                        aria-disabled="true"><small>5</small> <span>Photos</span></a>

                                </div>
                                <div class="stepwizard-step">
                                    <a href="#step-6" type="button" class="btn btn-default btn-circle" disabled
                                        aria-disabled="true"><small>6</small> <span>Rental Policies</span></a>

                                </div>
                                <div class="stepwizard-step">
                                    <a href="#step-7" type="button" class="btn btn-default btn-circle" disabled
                                        aria-disabled="true"><small>7</small> <span>Calendar</span></a>

                                </div>
                                <div class="stepwizard-step">
                                    <a href="#step-8" type="button" class="btn btn-default btn-circle" disabled
                                        aria-disabled="true"><small>8</small> <span>Reviews</span></a>

                                </div>
                                <div class="stepwizard-step">
                                    <a href="#step-9" type="button" class="btn btn-default btn-circle"
                                        disabled><small>9</small> <span>Owner Information</span></a>

                                </div>
                            </div>
                        </div>
                        <form id="listing_form">
                            <input type="hidden" name="property_id" value="{{ $property->id ?? '' }}">
                            <div class="row setup-content m-auto" id="step-1">
                                <div class="col-md-6">
                                    <label for="property_name" class="form-label">Property Name</label>
                                    <input type="text" class="form-control" id="property_name" placeholder="Name"
                                        name="property_name" value="{{ $property->property_name ?? '' }}">
                                    <span class="property_name-error text-danger"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="property_suitablity" class="form-label">Suitablity</label>
                                    <select name="property_suitablity[]" id="property_suitablity"
                                        class="form-control chosen-select" multiple data-placeholder="Suitablity">
                                        @php
                                            if (!empty($property)):
                                                $suitablityId = gettype($property->property_suitablity_id) != 'array'? json_decode($property->property_suitablity_id, true): $property->property_suitablity_id;
                                            endif;
                                        @endphp
                                        @if (!empty($properties_suitablities))
                                            @foreach ($properties_suitablities as $property_suitablity)
                                                <option value="{{ $property_suitablity->id }}"
                                                    @if (!empty($property)) @selected(in_array($property_suitablity->id, $suitablityId)) @endif>
                                                    {{ $property_suitablity->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="property_suitablity-error text-danger"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="property_main_image" class="form-label">Property Photo</label>
                                    @if (!empty($property))
                                        <input type="hidden" class="form-control" id="property_old_image"
                                            placeholder="Name" name="property_old_image"
                                            value="{{ $property->property_image }}">
                                    @endif
                                    <input type="file" class="form-control" id="property_main_image" placeholder="Name"
                                        name="property_main_image">
                                    <span class="property_main_image-error text-danger"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="square-feet">Square Feet</label>
                                    <input type="text" name="square_feet" class="form-control"
                                        placeholder="Square feet" id="square-feet"
                                        onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                        value="{{ $property->square_feet ?? '' }}">
                                    <span class="square_feet-error text-danger"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="propery-type">Property Type</label>
                                    <select class="form-control" name="property_type" id="propery-type">
                                        <option value="">Select Property type</option>
                                        @if (!empty($properties_type))
                                            @foreach ($properties_type as $property_type)
                                                <option value="{{ $property_type->id }}"
                                                    @if (!empty($property)) @selected($property_type->id == $property->property_types_id) @endif>
                                                    {{ $property_type->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="property_type-error text-danger"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="bedrooms">Bedrooms</label>
                                    <select class="form-control" name="bedrooms" id="bedrooms">
                                        <option value="">Select Bedrooms</option>
                                        @for ($i = 1; $i <= 20; $i++)
                                            @if ($i == 20)
                                                <option value="{{ $i }}+"
                                                    @if (!empty($property)) @selected($i . '+' == $property->bedrooms) @endif>
                                                    {{ $i }}+ Bedrooms</option>
                                            @else
                                                <option value="{{ $i }}"
                                                    @if (!empty($property)) @selected($i == $property->bedrooms) @endif>
                                                    {{ $i }} Bedrooms</option>
                                            @endif>
                                        @endfor
                                    </select>
                                    <span class="bedrooms-error text-danger"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="sleeps">Sleeps</label>
                                    <input type="text" name="sleeps" class="form-control" placeholder="Sleeps"
                                        id="sleeps"
                                        onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                        value="{{ $property->sleeps ?? '' }}">
                                    <span class="sleeps-error text-danger"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="avg-night">Avg. Night</label>
                                    <div class="input-group">
                                        <input type="text" name="avg_night" class="form-control"
                                            placeholder="Avg Night" aria-label="Avg Night" id="avg-night"
                                            onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                            value="{{ $property->avg_night ?? '' }}">
                                        <select name="rate_per_unit" class="input-group-text">
                                            <option value="">Select</option>
                                            <option
                                                value="Nightly"@if (!empty($property)) @selected($property->rate_per_unit == 'Nightly') @endif>
                                                Nightly Rate</option>
                                            <option
                                                value="Weekly"@if (!empty($property)) @selected($property->rate_per_unit == 'Weekly') @endif>
                                                Weekly Rate</option>
                                            <option value="Monthly"
                                                @if (!empty($property)) @selected($property->rate_per_unit == 'Monthly') @endif>
                                                Monthly Rate</option>
                                        </select>
                                    </div>
                                    <span class="avg_night-error text-danger"></span>
                                    <span class="rate_per_unit-error text-danger"
                                        style="
                                    margin-left: 23px;"></span>

                                </div>
                                <div class="col-md-6">
                                    <label for="baths">Baths</label>
                                    <select name="baths" class="form-control" placeholder="Baths" id="baths">
                                        <option value="">Select Baths </option>
                                        <option
                                            value="1"@if (!empty($property)) @selected($property->bathrooms == '1') @endif>
                                            1 Bathroom</option>
                                        <option
                                            value="1.5"@if (!empty($property)) @selected($property->bathrooms == '1.5') @endif>
                                            1.5 Bathrooms</option>
                                        <option
                                            value="2"@if (!empty($property)) @selected($property->bathrooms == '2') @endif>
                                            2 Bathrooms</option>
                                        <option
                                            value="2.5"@if (!empty($property)) @selected($property->bathrooms == '2.5') @endif>
                                            2.5 Bathrooms</option>
                                        <option
                                            value="3"@if (!empty($property)) @selected($property->bathrooms == '3') @endif>
                                            3 Bathrooms</option>
                                        <option
                                            value="3.5"@if (!empty($property)) @selected($property->bathrooms == '3.5') @endif>
                                            3.5 Bathrooms</option>
                                        <option
                                            value="4"@if (!empty($property)) @selected($property->bathrooms == '4') @endif>
                                            4 Bathrooms</option>
                                        <option
                                            value="4.5"@if (!empty($property)) @selected($property->bathrooms == '4.5') @endif>
                                            4.5 Bathrooms</option>
                                        <option
                                            value="5"@if (!empty($property)) @selected($property->bathrooms == '5') @endif>
                                            5 Bathrooms</option>
                                        <option
                                            value="5.5"@if (!empty($property)) @selected($property->bathrooms == '5.5') @endif>
                                            5.5 Bathrooms</option>
                                        <option
                                            value="6"@if (!empty($property)) @selected($property->bathrooms == '6') @endif>
                                            6 Bathrooms</option>
                                        <option
                                            value="6.5"@if (!empty($property)) @selected($property->bathrooms == '6.5') @endif>
                                            6.5 Bathrooms</option>
                                        <option
                                            value="7"@if (!empty($property)) @selected($property->bathrooms == '7') @endif>
                                            7 Bathrooms</option>
                                        <option
                                            value="7.5"@if (!empty($property)) @selected($property->bathrooms == '7.5') @endif>
                                            7.5 Bathrooms</option>
                                        <option
                                            value="8"@if (!empty($property)) @selected($property->bathrooms == '8') @endif>
                                            8 Bathrooms</option>
                                        <option
                                            value="8.5"@if (!empty($property)) @selected($property->bathrooms == '8.5') @endif>
                                            8.5 Bathrooms</option>
                                        <option
                                            value="9"@if (!empty($property)) @selected($property->bathrooms == '9') @endif>
                                            9 Bathrooms</option>
                                        <option
                                            value="9.5"@if (!empty($property)) @selected($property->bathrooms == '9.5') @endif>
                                            9.5 Bathrooms</option>
                                        <option
                                            value="10"@if (!empty($property)) @selected($property->bathrooms == '10') @endif>
                                            10 Bathrooms</option>
                                        <option
                                            value="10.5"@if (!empty($property)) @selected($property->bathrooms == '10.5') @endif>
                                            10.5 Bathrooms</option>
                                        <option
                                            value="11"@if (!empty($property)) @selected($property->bathrooms == '11') @endif>
                                            11 Bathrooms</option>
                                        <option
                                            value="11.5"@if (!empty($property)) @selected($property->bathrooms == '11.5') @endif>
                                            11.5 Bathrooms</option>
                                        <option
                                            value="12"@if (!empty($property)) @selected($property->bathrooms == '12') @endif>
                                            12 Bathrooms</option>
                                        <option
                                            value="12.5"@if (!empty($property)) @selected($property->bathrooms == '12.5') @endif>
                                            12.5 Bathrooms</option>
                                        <option
                                            value="13"@if (!empty($property)) @selected($property->bathrooms == '13') @endif>
                                            13 Bathrooms</option>
                                        <option
                                            value="13.5"@if (!empty($property)) @selected($property->bathrooms == '13.5') @endif>
                                            13.5 Bathrooms</option>
                                        <option
                                            value="14"@if (!empty($property)) @selected($property->bathrooms == '14') @endif>
                                            14 Bathrooms</option>
                                        <option
                                            value="14.5"@if (!empty($property)) @selected($property->bathrooms == '14.5') @endif>
                                            14.5 Bathrooms</option>
                                        <option
                                            value="15"@if (!empty($property)) @selected($property->bathrooms == '15') @endif>
                                            15 Bathrooms</option>
                                        <option
                                            value="15.5"@if (!empty($property)) @selected($property->bathrooms == '15.5') @endif>
                                            15.5 Bathrooms</option>
                                        <option
                                            value="16"@if (!empty($property)) @selected($property->bathrooms == '16') @endif>
                                            16 Bathrooms</option>
                                        <option
                                            value="17"@if (!empty($property)) @selected($property->bathrooms == '17') @endif>
                                            17 Bathrooms</option>
                                        <option
                                            value="18"@if (!empty($property)) @selected($property->bathrooms == '18') @endif>
                                            18 Bathrooms</option>
                                        <option
                                            value="19"@if (!empty($property)) @selected($property->bathrooms == '19') @endif>
                                            19 Bathrooms</option>
                                        <option
                                            value="20"@if (!empty($property)) @selected($property->bathrooms == '20') @endif>
                                            20 Bathrooms</option>
                                        <option value="Studio"
                                            @if (!empty($property)) @selected($property->bathrooms == 'Studio') @endif>Studio
                                        </option>
                                    </select>
                                    <span class="baths-error text-danger"></span>
                                </div>
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-12">
                                    <label for="description">Description</label>
                                    <textarea class="form-control h-150px" rows="6" id="description" name="description">{{ $property->description ?? '' }}</textarea>
                                    <span class="description-error text-danger"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="property_location">Country</label>
                                    <select class="form-control" name="country_name" id="country_name"
                                        onchange="getStates(this.value)">
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}"
                                                @if (!empty($property)) @selected($property->country_id == $country->id) @endif>
                                                {{ ucfirst($country->name) }}</option>
                                        @endforeach
                                    </select>
                                    <span class="country_name-error text-danger"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="state_name">State</label>
                                    <select name="state_name" id="state_name" class="form-control"
                                        onchange="getRegion(this.value)">
                                        <option value="">Select State</option>
                                        @if (!empty($states))
                                            @foreach ($states as $state)
                                                <option value="{{ $state->id }}"
                                                    @if (!empty($property)) @selected($property->state_id == $state->id) @endif>
                                                    {{ ucfirst($state->name) }}</option>
                                            @endforeach
                                        @endif;
                                    </select>
                                    <span class="state_name-error text-danger"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="region_name" class="form-label">Region Name</label>
                                    <select name="region_name" id="region_name" class="form-control"
                                        onchange="getCity(this.value)">
                                        <option value="">Select Region</option>
                                        @if (!empty($regions))
                                            @foreach ($regions as $region)
                                                <option value="{{ $region->id }}"
                                                    @if (!empty($property)) @selected($property->region_id == $region->id) @endif>
                                                    {{ ucfirst($region->name) }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="region_name-error text-danger"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="city_name">City</label>
                                    <select class="form-control" name="city_name" id="city_name"
                                        onchange="getSubCity(this.value)">
                                        <option value="">Select City</option>
                                        @if (!empty($cities))
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}"
                                                    @if (!empty($property)) @selected($property->city_id == $city->id) @endif>
                                                    {{ ucfirst($city->name) }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="city_name-error text-danger"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="sub_city_name">Sub City</label>
                                    <select class="form-control" name="sub_city" id="sub_city_name">
                                        <option value="">Select Sub city</option>
                                        @if (!empty($subCities))
                                            @foreach ($subCities as $subCity)
                                                <option value="{{ $subCity->id }}"
                                                    @if (!empty($property)) @selected($property->sub_city_id == $subCity->id) @endif>
                                                    {{ ucfirst($subCity->name) }}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="extrnal_website_link">External Link(Video , Virtual Tour)</label>
                                    <input type="text" class="form-control" id="extrnal_link"
                                        placeholder="External Website Link" name="external_website_link"
                                        value="{{ $property->extrnal_link ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="personal_website_link">Personal Website Link</label>
                                    <input type="text" name="personal_website_link" id="personal_website_link"
                                        placeholder="Personal Website Link"
                                        value="{{ $property->personal_website_link ?? '' }}" class="form-control">
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-10 ml-auto">
                                        <button type="button" class="btn btn-primary property_information">Next</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row setup-content m-auto" id="step-2">
                                <div class="accordion mt-3" id="accordionExample">
                                    @if (!empty($property))
                                        @php
                                            $subAmenitiesId = [];
                                            $childAmenitiesId = [];
                                            $amenities = $property->property_amenites->toArray();
                                            foreach ($amenities as $aminity):
                                                if ($aminity['child_amenites_id'] != null):
                                                    $childAmenitiesId[] = $aminity['child_amenites_id'];
                                                else:
                                                    $subAmenitiesId[] = $aminity['sub_amenites_id'];
                                                endif;
                                            endforeach;
                                        @endphp
                                    @endif
                                    @if (!empty($ammienites))
                                        @foreach ($ammienites as $aminity)
                                            <div class="card accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button type="button" class="accordion-button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#ammienties_{{ $aminity->id }}"
                                                        aria-expanded="true" aria-controls="accordionOne">
                                                        <span>{{ $aminity->name }}</span> <br>
                                                        {{-- <p>{{ $aminity->description }}</p> --}}
                                                    </button>
                                                </h2>
                                                <div id="ammienties_{{ $aminity->id }}"
                                                    class="accordion-collapse collapse show"
                                                    data-bs-parent="#accordionExample" style="">
                                                    <div class="accordion-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    @if (!empty($aminity->sub_amenities))
                                                                        @foreach ($aminity->sub_amenities as $subAmenities)
                                                                            @if (count($subAmenities->child_amienites) <= 0)
                                                                                <div class="col-md-4 mt-4">
                                                                                    <input
                                                                                        class="form-check-input amenites"
                                                                                        type="checkbox"
                                                                                        name="sub_amenites[]"
                                                                                        value="{{ $subAmenities->id }}"
                                                                                        id="per_{{ $subAmenities->id }}"
                                                                                        data-level="subAmenities"
                                                                                        @isset($subAmenitiesId)
                                                                                            @if (in_array($subAmenities->id, $subAmenitiesId))
                                                                                                checked
                                                                                            @endif
                                                                                        @endisset>
                                                                                    <label class="form-check-label"
                                                                                        for="per_{{ $subAmenities->id }}"
                                                                                        style="margin: 0px;">{{ ucfirst($subAmenities->name) }}</label>
                                                                                    <div
                                                                                        class="description_{{ $subAmenities->id }}">
                                                                                        @isset($subAmenitiesId)
                                                                                            @if (in_array($subAmenities->id, $subAmenitiesId))
                                                                                                @if (App\Http\Helper\Helper::checkDescriptionAmenites($subAmenities->id, 'sub_amenities'))
                                                                                                    <textarea placeholder="Describe yourself here..." class="form-control h-150px" rows="2" name="description"> </textarea>
                                                                                                @endif
                                                                                            @endif
                                                                                        @endisset
                                                                                    </div>
                                                                                </div>
                                                                            @else
                                                                                <h6>{{ ucfirst($subAmenities->name) }}
                                                                                </h6>
                                                                                @foreach ($subAmenities->child_amienites as $childAminites)
                                                                                    <div class="col-md-4 mt-4">
                                                                                        @php
                                                                                            // echo $childAminites->name;
                                                                                            $typeCheckBox = '';
                                                                                            if (
                                                                                                $subAmenities->name ===
                                                                                                    'Breakfast' ||
                                                                                                $subAmenities->name ===
                                                                                                    'Housekeeping'
                                                                                            ):
                                                                                                $typeCheckBox = 'radio';
                                                                                            else:
                                                                                                $typeCheckBox =
                                                                                                    'checkbox';
                                                                                            endif;
                                                                                        @endphp
                                                                                        <input
                                                                                            class="form-check-input amenites"
                                                                                            type="{{ $typeCheckBox }}"
                                                                                            name="sub_amenites[]"
                                                                                            value="{{ $childAminites->id }}"
                                                                                            id="per_child_{{ $childAminites->id }}"
                                                                                            data-level="chlidrenAmenites"
                                                                                            @isset($childAmenitiesId)
                                                                                            @if (in_array($childAminites->id, $childAmenitiesId))
                                                                                                checked
                                                                                            @endif
                                                                                        @endisset>
                                                                                        <label class="form-check-label"
                                                                                            for="per_child_{{ $childAminites->id }}"
                                                                                            style="margin: 0px;">{{ ucfirst($childAminites->name) }}</label>
                                                                                        <div
                                                                                            class="description_per_{{ $childAminites->id }}">
                                                                                            @isset($childAmenitiesId)
                                                                                                @if (in_array($childAminites->id, $childAmenitiesId))
                                                                                                    @if (App\Http\Helper\Helper::checkDescriptionAmenites($subAmenities->id, 'child_amenities'))
                                                                                                        <textarea placeholder="Describe yourself here..." class="form-control h-150px" rows="2" name="description"> </textarea>
                                                                                                    @endif
                                                                                                @endif
                                                                                            @endisset
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                                <hr style="margin-top:50px">
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-10 ml-auto mr-2">
                                        <button type="button" class="btn btn-danger prevBtn">Back</button>
                                        <button type="button" class="btn btn-primary amenities">Next</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row setup-content m-auto" id="step-3">
                                <div class="col-md-12">
                                    <label for="location">Address</label>
                                    <input type="text" class="form-control" id="location" name="location"
                                        placeholder="Search address" value="{{ $property->address ?? '' }}">
                                </div>
                                <div class="col-md-12">
                                    {{-- <div class="form-group"> --}}
                                    <div id="map" style="width:100%;height:600px;margin-top:10px;"></div>
                                    <div id="infowindow-content">
                                        <span id="place-name" class="title"></span><br />
                                        <span id="place-address"></span>
                                    </div>
                                    {{-- </div> --}}
                                </div>
                                <div class="col-md-6">
                                    <label for="iframe_link">Iframe Link</label>
                                    <input type="text" class="form-control" id="iframe_link" name="iframe_link"
                                        placeholder="Iframe Link" value="{{ $property->iframe_link ?? '' }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" class="form-control" id="latitude" name="latitude"
                                        value="{{ $property->latitude ?? '' }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="longitude">Longitude</label>
                                    <input type="text" class="form-control" id="longitude" name="longitude"
                                        value="{{ $property->longitude ?? '' }}">
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-10 ml-auto mr-2">
                                        <button type="button" class="btn btn-danger prevBtn">Back</button>
                                        <button type="button" class="btn btn-primary location_info">Next</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row setup-content m-auto" id="step-4">
                                <div class="col-md-2">
                                    <label for="session_name">Season Name</label>
                                    <input type="text" name="session_name" class="form-control" id="session_name"
                                        placeholder="Session Name">
                                    <span class="session_name text-danger"></span>
                                </div>
                                <div class="col-md-2">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" name="start_date" class="form-control" id="start_date">
                                    <span class="from_date text-danger"></span>
                                </div>
                                <div class="col-md-2">
                                    <label for="end_date">End Date</label>
                                    <input type="date" name="end_date" class="form-control" id="end_date">
                                    <span class="end_date text-danger"></span>
                                </div>
                                <div class="col-md-2">
                                    <label for="nightly_rate">Nightly Rate</label>
                                    <input type="text" name="nightly_rate" class="form-control"
                                        onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                    <span class="nightly_rate text-danger"></span>
                                </div>
                                <div class="col-md-2">
                                    <label for="weekly_rate">Weekly Rate</label>
                                    <input type="text" name="weekly_rate" class="form-control" id="weekly_rate"
                                        onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                    <span class="weekly_rate text-danger"></span>
                                </div>
                                <div class="col-md-2">
                                    <label for="weekend_rate">Weekend Rate</label>
                                    <input type="text" name="weekend_rate" class="form-control" id="weekend_rate"
                                        onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                    <span class="weekend_rate text-danger"></span>
                                </div>
                                <div class="col-md-2">
                                    <label for="monthly_rate">Monthly Rate</label>
                                    <input type="text" name="monthly_rate" class="form-control" id="monthly_rate"
                                        onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                    <span class="monthly_rate text-danger"></span>
                                </div>
                                <div class="col-md-2">
                                    <label for="minimum_stay">Minimum Stay</label>
                                    <input type="text" name="minimum_stay" class="form-control" id="minimum_stay"
                                        onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                    <span class="minimum_stay text-danger"></span>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary add_rates" style="margin-top:40px;">Add
                                        Rates</button>
                                </div>
                                <div class="col-md-12 text-nowrap mt-4 padnone">
                                    <table class="table" style="width:100%" id="property_rates">
                                        <thead>
                                            <tr>
                                                <th>Sr No.</th>
                                                <th>Season Name</th>
                                                <th>From Date</th>
                                                <th>To Date</th>
                                                <th>Nightly Rate</th>
                                                <th>Weekly Rate</th>
                                                <th>Weekend Rate</th>
                                                <th>Monthly Rate</th>
                                                <th>Minimum Stay</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <h5>Fees - Define your fees, like cleaning, etc.</h5>
                                </div>
                                <div class="col-md-2">
                                    <label for="admin_fees">Admin Fee</label>
                                    <input type="text" name="admin_fees" class="form-control" id="admin_fees"
                                        onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                        value="{{ $property->admin_fees ?? '' }}">
                                    <span class="admin_fees text-danger"></span>
                                </div>
                                <div class="col-md-2">
                                    <label for="cleaning_fees">Cleaning Fees</label>
                                    <input type="text" name="cleaning_fees" class="form-control" id="cleaning_fees"
                                        onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                        value="{{ $property->cleaning_fees ?? '' }}">
                                    <span class="cleaning_fees text-danger"></span>
                                </div>
                                <div class="col-md-3">
                                    <label for="refundable_damage_deposite">Refundable Damage Deposit</label>
                                    <input type="text" name="refundable_damage_deposite" class="form-control"
                                        id="refundable_damage_deposite"
                                        onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                        value="{{ $property->refundable_damage_deposite ?? '' }}">
                                    <span class="refundable_damage_deposite text-danger"></span>
                                </div>
                                <div class="col-md-2">
                                    <label for="danage_waiver">Damage Waiver</label>
                                    <input type="text" name="danage_waiver" class="form-control" id="danage_waiver"
                                        value="{{ $property->danage_waiver ?? '' }}"
                                        onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                    <span class="danage_waiver text-danger"></span>
                                </div>
                                <div class="col-md-3">
                                    <label for="pet_fees">Pet Fee</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Pet fee"
                                            aria-label="Pet Fee" id="pet_fees"
                                            onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                            name="pet_fee" value="{{ $property->pet_fee ?? '' }}">
                                        <select name="pet_rate_per_unit" class="input-group-text">
                                            <option value="">Select</option>
                                            <option value="Per Day"
                                                @if (!empty($property)) @selected($property->pet_rate_per_unit == 'Per Day') @endif>Per
                                                Day</option>
                                            <option value="Per Week"
                                                @if (!empty($property)) @selected($property->pet_rate_per_unit == 'Per Week') @endif>Per
                                                Week</option>
                                            <option value="Per Stay"
                                                @if (!empty($property)) @selected($property->pet_rate_per_unit == 'Per Stay') @endif>Per
                                                Stay</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <label class="form-check-label" for="pet_allowed" style="margin: 0px;">Pet
                                        Allowed</label>
                                    <input class="form-check-input" type="checkbox" name="pet_alloewd" id="pet_allowed"
                                        value="1"
                                        @if (!empty($property)) @checked($property->pet_allowed == 1) @endif>
                                </div>
                                <div class="col-md-2 mt-2">
                                    <label class="form-check-label" for="smoked_allowed" style="margin: 0px;">Smoked
                                        Allowed</label>
                                    <input class="form-check-input" type="checkbox" name="smoked_allowed"
                                        id="smoked_allowed" value="1"
                                        @if (!empty($property)) @checked($property->smoking_allowed == 1) @endif>
                                </div>
                                <div class="col-md-2">
                                    <label for="extra_person_fee">Extra Person Fee</label>
                                    <input type="text" name="extra_person_fee" class="form-control"
                                        id="extra_person_fee" placeholder="Extra Person Fees"
                                        value="{{ $property->extra_person_fee ?? '' }}"
                                        onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                    <span class="extra_person_fee text-danger"></span>
                                </div>
                                <div class="col-md-2">
                                    <label for="after">After</label>
                                    <select name="after_guest" id="after" class="form-control">
                                        <option value="">Select Guests</option>
                                        @for ($i = 1; $i <= 25; $i++)
                                            @if ($i == 25)
                                                <option value="{{ $i }}+"
                                                    @if (!empty($property)) @selected($i . '+' == $property->after_guest) @endif>
                                                    {{ $i }} + Guests</option>
                                            @else
                                                <option value="{{ $i }}"
                                                    @if (!empty($property)) @selected($i == $property->after_guest) @endif>
                                                    {{ $i }} Guests</option>
                                            @endif
                                        @endfor
                                    </select>
                                    <span class="after text-danger"></span>
                                </div>
                                <div class="col-md-2">
                                    <label for="poolheating_fee">Pool Heating Fee</label>
                                    <input type="text" name="poolheating_fee" class="form-control"
                                        id="poolheating_fee" placeholder="Pool Heating fess"
                                        value="{{ $property->poolheating_fee ?? '' }}"
                                        onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                    <span class="poolheating_fee text-danger"></span>
                                </div>
                                <div class="col-md-2">
                                    <label for="pool_heating_fees_perday">Per Day</label>
                                    <select name="pool_heating_fees_perday" id="pool_heating_fees_perday"
                                        class="form-control">
                                        <option value="">Select Day</option>
                                        <option value="Per Day"
                                            @if (!empty($property)) @selected($property->pool_heating_fees_perday == 'Per Day') @endif>Per Day
                                        </option>
                                        <option value="Per Week"
                                            @if (!empty($property)) @selected($property->pool_heating_fees_perday == 'Per Week') @endif>Per
                                            Week</option>
                                        <option value="Per Stay"
                                            @if (!empty($property)) @selected($property->pool_heating_fees_perday == 'Per Stay') @endif>Per
                                            Stay</option>
                                    </select>
                                    <span class="after text-danger"></span>
                                </div>
                                <div class="col-md-2">
                                    <label for="check_in">Check In</label>
                                    <input type="time" name="check_in" class="form-control" id="check_in"
                                        placeholder="Pool Heating fess" value="{{ $property->check_in ?? '12:00' }}">
                                    <span class="check_in text-danger"></span>
                                </div>
                                <div class="col-md-2">
                                    <label for="check_out">Check Out</label>
                                    <input type="time" name="check_out" class="form-control" id="check_out"
                                        placeholder="Pool Heating fess" value="{{ $property->check_out ?? '12:00' }}">
                                    <span class="check_out text-danger"></span>
                                </div>
                                <div class="col-md-2">
                                    <label for="tax_rates">Tax Rates (%)</label>
                                    <input type="text" name="tax_rates" class="form-control" id="tax_rates"
                                        placeholder="Tax Rates(%)" value="{{ $property->tax_rates ?? '' }}"
                                        onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                    <span class="check_out text-danger"></span>
                                </div>
                                <div class="col-md-2">
                                    <label for="change_over">Change-Over</label>
                                    <select name="change_over" id="change_over" class="form-control">
                                        <option value="">Flexible</option>
                                        <option value="monday"
                                            @if (!empty($property)) @selected($property->change_over == 'monday') @endif>Monday
                                        </option>
                                        <option
                                            value="Tuesday"@if (!empty($property)) @selected($property->change_over == 'Tuesday') @endif>
                                            Tuesday</option>
                                        <option
                                            value="Wednesday"@if (!empty($property)) @selected($property->change_over == 'Wednesday') @endif>
                                            Wednesday</option>
                                        <option
                                            value="Thursday"@if (!empty($property)) @selected($property->change_over == 'Thursday') @endif>
                                            Thursday</option>
                                        <option
                                            value="Friday"@if (!empty($property)) @selected($property->change_over == 'Friday') @endif>
                                            Friday</option>
                                        <option
                                            value="Saturday"@if (!empty($property)) @selected($property->change_over == 'Saturday') @endif>
                                            Saturday</option>
                                        <option
                                            value="Sunday"@if (!empty($property)) @selected($property->change_over == 'Sunday') @endif>
                                            Sunday</option>
                                    </select>
                                    <span class="change_over text-danger"></span>
                                </div>
                                <div class="col-md-2">
                                    <label for="all_rates_are_in">All Rates are in</label>
                                    <select name="all_rates_are_in" id="all_rates_are_in" class="form-control">
                                        <option value="">Select Currency</option>
                                        @if (!empty($currencies))
                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->id }}"
                                                    @if (!empty($property)) @selected($property->currency_id == $currency->id) @else @selected($currency->id == 10) @endif>
                                                    {{ $currency->currency_name }}</option>
                                            @endforeach
                                        @endif;
                                    </select>
                                    <span class="all_rates_are_in text-danger"></span>
                                </div>
                                <div class="col-md-6"></div>
                                <div class="col-md-12">
                                    <label for="rates_notes">Rates Notes</label>
                                    <textarea class="form-control h-150px" rows="6" id="rates_notes" name="rates_notes">{{ $property->rates_notes ?? '' }}</textarea>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-10 ml-auto mr-2">
                                        <button type="button" class="btn btn-danger prevBtn">Back</button>
                                        <button type="button" class="btn btn-primary rental_rates">Next</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row setup-content m-auto" id="step-5">
                                <div class="col-md-12">
                                    <label for="property-gallery-image" class="form-label">Property Gallery Image</label>
                                    <input type="file" class="form-control" id="property-gallery-image"
                                        placeholder="Name" name="property-gallery-image"
                                        accept="image/png, image/gif, image/jpeg , image/jpg" multiple accept=""
                                        onchange="image_select()" />
                                </div>
                                <div class="card-body d-flex flex-wrap justify-content-start" id="container">
                                    @if (!empty($property))
                                        @foreach ($property->galleryImage as $galleryImage)
                                            <div class="image_container d-flex justify-content-center position-relative" id="gallery_image_{{ $galleryImage->id }}">
                                                <img src="{{ env('IMAGE_URL') . '/upload/property_image/gallery_image/' . $property->id . '/' . $galleryImage->image_name }}"
                                                    alt="Image" srcset="">
                                                <span class="position-absolute"
                                                    onclick="deleteGalleryImage({{ $galleryImage->id }})">&times;</span>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-10 ml-auto mr-2">
                                        <button type="button" class="btn btn-danger prevBtn">Back</button>
                                        <button type="button" class="btn btn-primary gallery_image">Next</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row setup-content m-auto" id="step-6">
                                <div class="col-md-12">
                                    <label for="rental_policies">Rental Policies</label>
                                    <textarea class="form-control h-150px" rows="6" id="rental_policies" name="rental_policies">
                                        {{ $property->rental_policies ?? '' }}
									</textarea>
                                </div>
                                <div class="col-md-12">
                                    <label for="cancel_polices">Cancellation Policies</label>
                                    <textarea class="form-control h-150px" rows="6" id="cancel_polices" name="cancel_polices">
                                        {{ $property->cancel_polices ?? '' }}
									</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="upload_rental_policies">Upload Rental Agreement</label>
                                    <input type="file" class="form-control" id="upload_rental_policies"
                                        name="upload_rental_policies">
                                </div>
                                <div class="col-md-6">
                                    <label for="upload_cancel_policies">Upload Cancellation Policies</label>
                                    <input type="file" class="form-control" id="upload_cancel_policies"
                                        name="upload_cancel_policies">
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-10 ml-auto mr-2">
                                        <button type="button" class="btn btn-danger prevBtn">Back</button>
                                        <button type="button" class="btn btn-primary rental_policies">Next</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row setup-content m-auto" id="step-7">
                                <div class="col-md-9">
                                    <label for="import_calender_url">Import Calender Url</label>
                                    <input type="text" name="import_calender_url" class="form-control"
                                        id="import_calender_url" placeholder="Import Calender link"
                                        value="{{ $property->ical_link ?? '' }}">
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-primary sync_now" style="margin: 36px;">Sync Now</button>
                                </div>
                                <div class="col-md-12">
                                    <a href="javascript:void()" class="btn btn-primary" onclick="exportIcalLink({{ $property->id ?? '' }})">Export Calender (iCal File)</a>
                                    <a class="copy_text btn btn-primary d-none" data-toggle="tooltip" title="Copy to Clipboard" href="">Copy ical Link</a>
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#manual-booking-modal">
                                        <i class="bx bx-plus"></i> Add Manual Booking
                                    </button>
                                </div>
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
                                <div class="form-group row mt-3">
                                    <div class="col-md-10 ml-auto mr-2">
                                        <button type="button" class="btn btn-danger prevBtn">Back</button>
                                        <button type="button" class="btn btn-primary calender_syncronization">Next</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row setup-content m-auto" id="step-8">
                                <div class="col-md-6">
                                    <label for="reviews_heading">Reviews Heading</label>
                                    <input type="text" class="form-control" id="reviews_heading"
                                        name="reviews_heading">
                                    <span class="text-danger reviews_heading"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="guest_name">Guest Name</label>
                                    <input type="text" class="form-control" id="guest_name" name="guest_name">
                                    <span class="text-danger guest_name"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="place">Place</label>
                                    <input type="text" class="form-control" id="place" name="place">
                                    <span class="text-danger place"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="reviews">Reviews</label>
                                    <textarea class="form-control" id="reviews" name="reviews" rows="5"></textarea>
                                    <span class="text-danger reviews"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="rating">Rating</label>
                                    <select name="rating" id="rating" class="form-control">
                                        <option value="">Select Rating</option>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}">{{ $i }} Star</option>
                                        @endfor
                                    </select>
                                    <span class="text-danger rating"></span>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary add_reviews"
                                        style="margin-top:37px;">Add Reviews</button>
                                </div>
                                <div class="col-md-12 text-nowrap mt-4">
                                    <table class="table" style="width:100%" id="property_reviews">
                                        <thead>
                                            <tr>
                                                <th>Sr No.</th>
                                                <th>Reviews Heading</th>
                                                <th>Guest Name</th>
                                                <th>Place</th>
                                                <th>Reviews</th>
                                                <th>Rating</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-10 ml-auto mr-2">
                                        <button type="button" class="btn btn-danger prevBtn">Back</button>
                                        <button type="button" class="btn btn-primary reviews_rating">Next</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row setup-content m-auto" id="step-9">
                                @php
                                    if (!empty($property)):
                                        $name = explode(' ', $property->user->name);
                                    endif;
                                @endphp
                                <div class="col-md-6">
                                    @if (!empty($property))
                                        <input type="hidden" name="user_information_update"
                                            value="user_information_update">
                                    @endif
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        value="@if (isset($name)) {{ array_key_exists('0', $name) ? $name['0'] : '' }} @endif">
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        value="@if (isset($name)) {{ array_key_exists('1', $name) ? $name['1'] : '' }} @endif">
                                </div>
                                <div class="col-md-6">
                                    <label for="primary_email">Primary Email</label>
                                    <input type="text" class="form-control" id="primary_email" name="primary_email"
                                        value="{{ $property->user->email ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="secondary_email">Secondary Email</label>
                                    <input type="text" class="form-control" id="secondary_email"
                                        name="secondary_email"
                                        value="{{ $property->userInformation->secondary_email ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="phone"> Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ $property->userInformation->phone ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="alternate_phone">Alternate Phone</label>
                                    <input type="text" class="form-control" id="alternate_phone"
                                        name="alternate_phone"
                                        value="{{ $property->userInformation->alternate_phone ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        value="{{ $property->userInformation->address ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" id="city" name="city"
                                        value="{{ $property->userInformation->city ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="state">State</label>
                                    <input type="text" class="form-control" id="state" name="state"
                                        value="{{ $property->userInformation->state ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="year_purchased">Year Purchased</label>
                                    <input type="text" class="form-control" id="year_purchased" name="year_purchased"
                                        value="{{ $property->userInformation->year_purchased ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="about_you">About You</label>
                                    <textarea class="form-control" id="about_you" name="about_you" rows="1">{{ $property->userInformation->about_you ?? '' }}</textarea>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-10 ml-auto mr-2">
                                        <button type="button" class="btn btn-danger prevBtn">Back</button>
                                        <button type="button" class="btn btn-primary owner_information">Next</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- Edit Rental Rates Model Start --}}
            <div class="modal fade" id="edit-rental-rates" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel3">Edit Rentals Rates</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form id="editrentalrate">
                            <div class="modal-body">
                                <div class="row g-2">
                                    <div class="col mb-0 col-md-6">
                                        <input type="hidden" name="id">
                                        <label for="session_name" class="form-label">Session Name</label>
                                        <input type="text" id="session_name" class="form-control"
                                            placeholder="Session name" value="" name="session_name" />
                                    </div>
                                    <div class="col mb-0 col-md-6">
                                        <label for="start_date" class="form-label">Start Date</label>
                                        <input type="date" id="start_date" class="form-control" name="start_date" />
                                    </div>
                                    <div class="col mb-0 col-md-6">
                                        <label for="end_date" class="form-label">End Date</label>
                                        <input type="date" id="end_date" class="form-control" name="end_date" />
                                    </div>
                                    <div class="col mb-0 col-md-6">
                                        <label for="nightly_rate" class="form-label">Nightly Rate</label>
                                        <input type="text" id="nightly_rate" class="form-control" name="nightly_rate"
                                            onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                    </div>
                                    <div class="col mb-0 col-md-6">
                                        <label for="weekly_rate" class="form-label">Weekly Rate</label>
                                        <input type="text" id="weekly_rate" class="form-control" name="weekly_rate"
                                            onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                    </div>
                                    <div class="col mb-0 col-md-6">
                                        <label for="weekend_rate" class="form-label">Weekend Rate</label>
                                        <input type="text" id="weekend_rate" class="form-control" name="weekend_rate"
                                            onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                    </div>
                                    <div class="col mb-0 col-md-6">
                                        <label for="monthly_rate" class="form-label">Monthy Rate</label>
                                        <input type="text" id="monthly_rate" class="form-control" name="monthly_rate"
                                            onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                    </div>
                                    <div class="col mb-0 col-md-6">
                                        <label for="minimum_stay" class="form-label">Minimum Stay</label>
                                        <input type="text" id="minimum_stay" class="form-control" name="minimum_stay"
                                            onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- Edit Rental Rates Model End --}}
            {{-- Edit Rental reviews Model Start --}}
            <div class="modal fade" id="edit-rviews" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel3">Edit Reviews & Rating</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form id="editReviews">
                            <div class="modal-body">
                                <div class="row g-2">
                                    <div class="col mb-0 col-md-6">
                                        <input type="hidden" name="id">
                                        <label for="reviews_heading" class="form-label">Reviews Heading</label>
                                        <input type="text" id="reviews_heading" class="form-control"
                                            placeholder="Session name" value="" name="reviews_heading" />
                                    </div>
                                    <div class="col mb-0 col-md-6">
                                        <label for="guest_name" class="form-label">Guest Name</label>
                                        <input type="text" id="guest_name" class="form-control" name="guest_name" />
                                    </div>
                                    <div class="col mb-0 col-md-6">
                                        <label for="place" class="form-label">Place</label>
                                        <input type="text" id="place" class="form-control" name="place" />
                                    </div>
                                    <div class="col mb-0 col-md-6">
                                        <label for="reviews" class="form-label">Reviews</label>
                                        <input type="text" id="reviews" class="form-control" name="reviews">
                                    </div>
                                    <div class="col mb-0 col-md-6">
                                        <label for="rating_update" class="form-label">Rating</label>
                                        <select name="rating_update" id="rating_update" class="form-control">
                                            <option value="">Select Rating</option>
                                            @for ($i = 1; $i <= 5; $i++)
                                                <option value="{{ $i }}">{{ $i }} Star</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- Edit Rental reviews Model End --}}
            {{-- Manual Booking Modal Start --}}
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
    <!-- / Content -->
@endsection
@push('js')
    <script>
        var lat = {{ $properties->latitude??'21.1702' }};
        var lon = {{ $properties->longitude??'72.8311' }};
    </script>
    <script src="{{ asset('frontend-assets/js/chosen.jquery.min.js') }}"></script>
    <script src="{{ asset('admin-auth-assets/js/property/property_information.js') }}"></script>
    <script src="{{ asset('admin-auth-assets/js/property/amenities.js') }}"></script>
    <script src="{{ asset('admin-auth-assets/js/ck-editor.js') }}"></script>
    <script src="{{ asset('admin-auth-assets/js/property/rental_rates.js') }}"></script>
    <script src="{{ asset('admin-auth-assets/js/property/map.js') }}"></script>
    <script src="{{ asset('admin-auth-assets/js/property/gallery_image.js') }}"></script>
    <script async
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_KEY') }}&libraries=places&callback=initMap">
    </script>
    <script src="{{ asset('admin-auth-assets/js/property/rental_policies.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('admin-auth-assets/js/property/calender_synchronization.js') }}"></script>
    <script src="{{ asset('admin-auth-assets/js/property/reviews.js') }}"></script>
    <script src="{{ asset('admin-auth-assets/js/property/owner_information.js') }}"></script>

    <script>
        $(document).ready(function() {
            $(document).ready(function() {
                $(".chosen-select").chosen({
                    // SUITABLITY
                    placeholder_text_single: "Suitablity",
                    no_results_text: "Oops, nothing found!"
                })
            })
            // Step Form Variable
            var navListItems = $('div.setup-panel div a'),
                allWells = $('.setup-content'),
                allPrevBtn = $('.prevBtn');
            allWells.hide();
            navListItems.click(function(e) {
                e.preventDefault();
                var $target = $($(this).attr('href')),
                    $item = $(this);
                if (!$item.hasClass('disabled')) {
                    navListItems.removeClass('btn-primary').addClass('btn-default');
                    $item.addClass('btn-primary');
                    allWells.hide();
                    $target.show();
                    $target.find('input:eq(0)').focus();
                }
            });

            allPrevBtn.click(function() {
                var curStep = $(this).closest(".setup-content"),
                    curStepBtn = curStep.attr("id"),
                    prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev()
                    .children("a");
                prevStepWizard.removeAttr('disabled').trigger('click');
            });
            // first Step Open Form
            $('div.setup-panel div a.btn-primary').trigger('click');

            // Initialize CKEditor after wizard has shown step-1
            if (typeof initDescriptionEditor === 'function') {
                initDescriptionEditor();
            }
        });
    </script>
@endpush
