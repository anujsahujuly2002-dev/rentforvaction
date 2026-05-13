@extends('frontend.layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend-assets/css/dashboard.css') }}">
    <style>
        .table-box table.basic-table th, table.basic-table td{
            padding: 8px;
        }
        .add-some-rate select{
            padding: 0px;
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
                        <div class="small-title">Rental Rates</div>
                        <div class="add-listing-section">
                            <form id="rentalRates">
                                <input type="hidden" value="{{ request()->id }}" name="property_id">
                                <div class="with-forms">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>Session Name</label>
                                        <input type="text" placeholder="Session Name" name="session_name">
                                    </div>
                                    <!-- Status -->
                                    <div class="col-md-2">
                                        <label>Starts</label>
                                        <input type="date" name="start_date" class="start_date form-control" autocomplete="off" min="{{ date('Y-m-d') }}">
                                    </div>

                                    <!-- Type -->
                                    <div class="col-md-2">
                                        <label>Ends</label>
                                        <input type="date" name="end_date" class="end_date form-control" autocomplete="off" min="{{ date('Y-m-d') }}">
                                    </div>

                                    <div class="col-md-2">
                                        <label>Nightly</label>
                                        <input type="text" name="nightly_rate">
                                    </div>

                                    <div class="col-md-2">
                                        <label>Weekend Night</label>
                                        <input type="text" name="weekend_rate">
                                    </div>

                                    <div class="col-md-2">
                                        <label>Weekly</label>
                                        <input type="text" name="weekly_rate">
                                    </div>

                                    <div class="col-md-2">
                                        <label>Monthly</label>
                                        <input type="text" name="monthly_rate">
                                    </div>

                                    <div class="col-md-2">
                                        <label>Min Stay</label>
                                        <input type="text" name="minimum_stay" id="" >
                                    </div>

                                    <div class="col-md-2">
                                       <button class="button" style="margin-top: 40px; width: 100%; padding: 10px 15px;">Add</button>
                                    </div>
                                </div>
                                </div>
                            </form>
                            <!-- Row / End -->
                            <hr>
                            <div class="table-box">
                                <table class="basic-table booking-table table-responsive" id="rental-rates">
                                    <thead>
                                        <tr>
                                            <th>Sr no.</th>
                                            <th>Session Name</th>
                                            <th>Starts</th>
                                            <th>Ends</th>
                                            <th>Nightly</th>
                                            <th>Weekend Night</th>
                                            <th>Weekly</th>
                                            <th>Monthly</th>
                                            <th>Min Stay</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <hr>

                            <div class="add-some-rate row m-auto" style="margin: 8px;">
                                <h5>Fees - Define your fees, like cleaning, etc.</h5>
                                <form id="addMoreRates">
                                    <input type="hidden" name="property_id" value="{{ request()->id }}">
                                    @if (!empty($properties))
                                        <input type="hidden" name="type" value="edit">
                                    @endif
                                    <div class="col-md-2">
                                        <label for="admin_fees">Admin Fee</label>
                                        <input type="text" name="admin_fees" class="form-control" id="admin_fees" onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')" value="{{ $properties->admin_fees??"" }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="cleaning_fees">Cleaning Fees</label>
                                        <input type="text" name="cleaning_fees" class="form-control" id="cleaning_fees" onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')" value="{{ $properties->cleaning_fees??"" }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="refundable_damage_deposite">Refundable Damage Deposit</label>
									    <input type="text" name="refundable_damage_deposite" class="form-control" id="refundable_damage_deposite" onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')" value="{{ $properties->refundable_damage_deposite??"" }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="danage_waiver">Damage Waiver</label>
                                        <input type="text" name="danage_waiver" class="form-control" id="danage_waiver" value="" onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')" value="{{ $properties->danage_waiver??"" }}">
                                        <span class="danage_waiver text-danger"></span>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="pet_fees">Pet Fee</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Pet fee" aria-label="Pet Fee"  id="pet_fees" onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')" name="pet_fee" value="{{ $properties->pet_fee??"" }}">
                                            <select name="pet_rate_per_unit" class="input-group-text">
                                                <option value="">Select</option>
                                                <option value="Nightly Rate" @if (!empty($properties))
                                                    @selected($properties->pet_rate_per_unit=="Nightly Rate")
                                                @endif>Nightly Rate</option>
                                                <option value="Weekly Rate"@if (!empty($properties))
                                                    @selected($properties->pet_rate_per_unit=="Weekly Rate")
                                                @endif>Weekly Rate</option>
                                                <option value="Monthly Rate" @if (!empty($properties))
                                                    @selected($properties->pet_rate_per_unit=="Monthly Rate")
                                                @endif>Monthly Rate</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-2">
                                        <label class="form-check-label" for="pet_allowed" style="margin-top: 18px;">Pet Allowed</label>
                                        <input class="form-check-input" type="checkbox" name="pet_alloewd" id="pet_allowed" value="1" @if (!empty($properties))
                                                    @checked($properties->pet_allowed=="1")
                                                @endif>
                                    </div>
                                    <div class="col-md-2 mt-2">
                                        <label class="form-check-label" for="smoked_allowed" style="margin-top: 18px;">Smoked Allowed</label>
                                        <input class="form-check-input" type="checkbox" name="smoked_allowed" id="smoked_allowed" value="1" @if (!empty($properties))
                                                    @checked($properties->smoking_allowed=="1")
                                                @endif>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="extra_person_fee">Extra Person Fee</label>
                                        <input type="text" name="extra_person_fee" class="form-control" id="extra_person_fee" placeholder="Extra Person Fees" value="{{ $properties->extra_person_fee??"" }}" onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                        <span class="extra_person_fee text-danger"></span>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="after">After</label>
                                        <select name="after_guest" id="after" class="form-control">
                                            <option value="">Select Guests</option>
                                            @for ($i=1;$i<=25;$i++)
                                                @if($i==25)
                                                    <option value="{{ $i }}+"  @if (!empty($properties))
                                                    @selected($properties->after_guest== $i."+")
                                                @endif>{{ $i }} + Guests</option>
                                                @else
                                                    <option value="{{ $i }}"  @if (!empty($properties))
                                                    @selected($properties->after_guest==$i)
                                                @endif>{{ $i }} Guests</option>
                                                @endif
                                            @endfor
                                        </select>
                                        <span class="after text-danger"></span>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="poolheating_fee">Pool Heating Fee</label>
                                        <input type="text" name="poolheating_fee" class="form-control" id="poolheating_fee" placeholder="Pool Heating fess" value="{{ $property->poolheating_fee??"" }}" onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                        <span class="poolheating_fee text-danger"></span>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="pool_heating_fees_perday">Per Day</label>
                                        <select name="pool_heating_fees_perday" id="pool_heating_fees_perday" class="form-control">
                                            <option value="">Select Day</option>
                                            <option value="Per Day" @if (!empty($properties))
                                                    @selected($properties->pool_heating_fees_perday=="Per Day")
                                                @endif>Per Day</option>
                                            <option value="Per Week" @if (!empty($properties))
                                                    @selected($properties->pool_heating_fees_perday=="Per Week")
                                                @endif>Per Week</option>
                                            <option value="Per Stay" @if (!empty($properties))
                                                    @selected($properties->pool_heating_fees_perday=="Per Stay")
                                                @endif>Per Stay</option>
                                        </select>
                                        <span class="after text-danger"></span>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="check_in">Check In</label>
                                        <input type="time" name="check_in" class="form-control" id="check_in" placeholder="Pool Heating fess" value="{{ $properties->check_in??"12:00" }}">
                                        <span class="check_in text-danger"></span>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="check_out">Check Out</label>
									    <input type="time" name="check_out" class="form-control" id="check_out" placeholder="Pool Heating fess" value="{{ $properties->check_out??"12:00" }}">
									    <span class="check_out text-danger"></span>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="tax_rates">Tax Rates (%)</label>
                                        <input type="text" name="tax_rates" class="form-control" id="tax_rates" placeholder="Tax Rates(%)" value="{{ $properties->tax_rates??"" }}"  onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                        <span class="check_out text-danger"></span>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="change_over">Change-Over</label>
                                        <select name="change_over" id="change_over" class="form-control">
                                            <option value="">Flexible</option>
                                            <option value="monday" @if (!empty($properties))
                                                    @selected($properties->change_over=="monday")
                                                @endif>Monday</option>
                                            <option value="Tuesday" @if (!empty($properties))
                                                    @selected($properties->change_over=="Tuesday")
                                                @endif>Tuesday</option>
                                            <option value="Wednesday" @if (!empty($properties))
                                                    @selected($properties->change_over=="Wednesday")
                                                @endif>Wednesday</option>
                                            <option value="Thursday" @if (!empty($properties))
                                                    @selected($properties->change_over=="Thursday")
                                                @endif>Thursday</option>
                                            <option value="Friday" @if (!empty($properties))
                                                    @selected($properties->change_over=="Friday")
                                                @endif>Friday</option>
                                            <option value="Saturday" @if (!empty($properties))
                                                    @selected($properties->change_over=="Saturday")
                                                @endif>Saturday</option>
                                            <option value="Sunday" @if (!empty($properties))
                                                    @selected($properties->change_over=="Sunday")
                                                @endif>Sunday</option>
                                        </select>
									    <span class="change_over text-danger"></span>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="all_rates_are_in">All Rates are in</label>
                                        <select name="all_rates_are_in" id="all_rates_are_in" class="form-control">
                                            <option value="">Select Currency</option>
                                            @if(!empty($currencies))
                                                @foreach($currencies as $currency)
                                                    <option value="{{ $currency->id }}" @if(!empty($properties)) @selected($currency->id==$properties->currency_id) @else @selected($currency->id==10) @endif>{{ $currency->currency_name }}</option>
                                                @endforeach
                                            @endif;
                                        </select>
									    <span class="all_rates_are_in text-danger"></span>
                                    </div>
                                    {{-- <div class="col-md-6"></div> --}}
                                    <div class="col-md-12">
                                    <label for="rates_notes">Rates Notes</label>
									    <textarea class="form-control h-150px" rows="6" id="rates_notes" name="rates_notes">{{ $properties->rates_notes??"" }}</textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="button preview">Save &amp; Update
                                                <i class="fa fa-arrow-circle-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="rentalRatesModel" tabindex="-1" role="dialog" aria-labelledby="rentalRatesModelLable" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="rentalRatesModelLable">Edit Rental Rates</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="editRentalRatesFrom">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" name="id" id="id">
                                        <div class="form-group">
                                            <label for="session_name" class="col-form-label">Session Name:</label>
                                            <input type="text" class="form-control" id="session_name" name="session_name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="start_date" class="col-form-label">Starts:</label>
                                            <input type="date" name="start_date" class="start_date form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="end_date" class="col-form-label">Ends:</label>
                                            <input type="date" name="end_date" class="end_date form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nightly_rate" class="col-form-label">Nightly</label>
                                            <input type="text" name="nightly_rate" id="nightly_rate" onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="weekend_rate" class="col-form-label">Weekend Night:</label>
                                            <input type="text" name="weekend_rate" id="weekend_rate" onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="weekly_rate" class="col-form-label">Weekly:</label>
                                            <input type="text" name="weekly_rate" id="weekly_rate" onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="monthly_rate" class="col-form-label">Monthly:</label>
                                            <input type="text" name="monthly_rate" id="monthly_rate" onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="minimum_stay" class="col-form-label">Min Stay:</label>
                                            <input type="text" name="minimum_stay" id="minimum_stay" onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-warning">Save changes</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('admin-auth-assets/js/common.js') }}"></script>
    <script src="{{ asset('frontend-assets/js/ownerJs/property/rental-rates.js') }}"></script>
@endpush
