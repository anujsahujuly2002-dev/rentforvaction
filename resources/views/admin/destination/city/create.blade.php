@extends('admin.layouts.master')
@section('title')
City Create
@endsection
@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    @include("toaster.toaster")
    <div class="row">
        <div class="col-md-6">
            <h4 class="fw-bold py-3 mb-4">City Create</h4>

        </div>
        <div class="col-md-6">
            <a href="{{ route('admin.destination.city.index') }}" class="btn btn-primary text-right" style="float: right">Back</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form id="city-create">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            @csrf
                            <div class="col-md-6">
                                <label for="country_name" class="form-label">Country Name</label>
                                <select name="country_name" id="country_name" class="form-control" onchange="getStates(this.value)">
                                    <option value="">Select Country</option>
                                    @if(!empty($countries))
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ ucfirst($country->name) }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <div class="country_name-error"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="state_name" class="form-label">State Name</label>
                                <select name="state_name" id="state_name" class="form-control" onchange="getRegion(this.value)">
                                    <option value="">Select State</option>
                                </select>                               
                                <div class="state_name-error"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="region_name" class="form-label">Region Name</label>
                                <select name="region_name" id="region_name" class="form-control" >
                                    <option value="">Select Region</option>
                                </select>                               
                                <div class="region_name-error"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="city_name" class="form-label">City Name</label>
                                <input type="text" name="city_name" id="city_name" class="form-control">                            
                                <div class="city_name-error"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary m-3">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
 <!-- / Content -->
@endsection
@push('js')
    <script src="{{ asset('admin-auth-assets/js/custom/destination/city.js') }}"></script>
@endpush