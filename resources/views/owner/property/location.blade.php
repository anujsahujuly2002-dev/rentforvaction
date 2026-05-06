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
            <div class="property-mainsection">
                <div class="row">
                    @include('owner.property.left-sidebar')
                    <div class="col-md-10">
                        <div class="small-title">Location</div>
                        <div class="add-listing-section">
                            <form id="propertyLocation">
                                <div class="with-forms">
                                    <div class="row">
                                        <input type="hidden" name="property_id" id="" value="{{ request()->id }}">
                                        @if (!empty($properties))
                                            <input type="hidden" name="type" value="edit">
                                        @endif
                                        <div class="col-md-12">
                                            <label for="location">Address</label>
                                            <input type="text" class="form-control" id="location" name="location" placeholder="Search address" value="{{ $properties->address??"" }}">
                                        </div>
                                        <div class="col-md-12">
                                            <div id="map" style="width:100%;height:600px;margin-top:10px;"></div>
                                            <div id="infowindow-content">
                                                <span id="place-name" class="title"></span><br />
                                                <span id="place-address"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="iframe_link">Iframe Link</label>
								            <input type="text" class="form-control" id="iframe_link" name="iframe_link" placeholder="Iframe Link" value="{{ $properties->iframe_link??"" }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="latitude">Latitude</label>
                                            <input type="text" class="form-control" id="latitude" name="latitude" value="{{ $properties->latitude??"" }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="longitude">Longitude</label>
                                            <input type="text" class="form-control" id="longitude" name="longitude" value="{{ $properties->longitude??"" }}">
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
<script>
    var lat = {{ $properties->latitude??'21.1702' }};
    var lon = {{ $properties->longitude??'72.8311' }};
</script>
<script src="{{ asset('admin-auth-assets/js/property/map.js') }}"></script>
<script async
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_KEY') }}&libraries=places&callback=initMap">
</script>

<script src="{{ asset('frontend-assets/js/ownerJs/property/location.js') }}"></script>

@endpush