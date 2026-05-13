@extends('frontend.layouts.master')
@push('css')
    <link href="{{ asset('frontend-assets/css/lightgallery.css') }}" rel="stylesheet">
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
            <div class="das-title">Owner Dashboard</div>
            @include('owner.layouts.owner-navbar')
            <div class="small-title">My Properties</div>
            @foreach ($properties as $property)
                <div class="row">
                <div class="col-md-10">
                    <div class="properties-listing">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="property-img"><img src="{{env('IMAGE_URL')}}/upload/property_image/main_image/{{$property->property_image}}" alt=""></div>
                            </div>
                            <div class="col-md-7">
                                <div class="properties-details">
                                    <ul>
                                        <li>{{ $property->property_name }}</li>
                                        <li>{{ $property->country->name }}, {{ $property->state->name }}, {{ $property?->city?->name }}</li>
                                        {{-- <li>Subscription Level : <strong>Platinum</strong></li> --}}
                                        {{-- <li>Listing Expires On : <strong>{{ $property->subscription_date !=null?date('F d Y',strtotime($property->subscription_date)):"NA" }} <a href="javascript:void(0)">Renew Now</a></strong></li> --}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    {{-- <div class="addnewlisting"><a href="javascript:void(0)">Add New Listing</a></div> --}}
                    <div class="listing-point">
                        <ul>
                            <li><a href="{{ route("owner.property.create",['id'=>$property->id,'type'=>"edit"]) }}">Edit Listing</a></li>
                            <li><a href="{{ route("owner.property.calendar",['id'=>$property->id]) }}">Update Calendar</a></li>
                            <li><a href="{{ route("owner.property.photos",['id'=>$property->id]) }}">Manage Photos</a></li>
                            <li><a href="{{ route("property.details",['id'=>$property->id]) }}">Preview Listing</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
@endsection
@push('js')
<script src="{{ asset('frontend-assets/js/dashboard-custom.js') }}"></script>

@endpush
