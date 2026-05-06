@extends('frontend.layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend-assets/css/dashboard.css') }}">
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
                        <div class="small-title">Rental Policies</div>
                        <div class="add-listing-section">
                            <form id="propertyRentalPolicies">
                                <div class="with-forms">
                                    <div class="row">
                                        <input type="hidden" name="property_id" value="{{ request()->id }}">
                                        @if (!empty($properties))
                                            <input type="hidden" name="type" value="edit">
                                        @endif
                                        <div class="col-md-12">
                                            <label for="rental_policies">Rental Policies</label>
                                            <textarea class="form-control h-150px" rows="6" id="rental_policies" name="rental_policies">{{ $properties->rental_policies??"" }}
                                            </textarea>
                                        </div>

                                        <div class="col-md-12">
                                            <label for="cancel_polices">Cancellation Policies</label>
                                            <textarea class="form-control h-150px" rows="6" id="cancel_polices" name="cancel_polices" >{{ $properties->cancel_polices??"" }}
                                            </textarea>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="upload_rental_policies">Upload Rental Agreement</label>
									        <input type="file" class="form-control" id="upload_rental_policies" name="upload_rental_policies">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="upload_cancel_policies">Upload Cancellation Policies</label>
									        <input type="file" class="form-control" id="upload_cancel_policies" name="upload_cancel_policies">
                                        </div>
                                        <div class="col-md-12">
                                            <button class="button preview" type="submit">Save &amp; Continue <i class="fa fa-arrow-circle-right"></i><button>
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
@endsection

@push('js')
    <script src="{{ asset('frontend-assets/js/ownerJs/property/rental-policies.js') }}"></script>
@endpush