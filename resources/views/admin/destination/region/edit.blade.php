@extends('admin.layouts.master')
@section('title')
Region Edit
@endsection
@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    @include("toaster.toaster")
    <div class="row">
        <div class="col-md-6">
            <h4 class="fw-bold py-3 mb-4">Region Edit</h4>

        </div>
        <div class="col-md-6">
            <a href="{{ route('admin.destination.region.index') }}" class="btn btn-primary text-right" style="float: right">Back</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form id="region-edit">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            @csrf
                            <input type="hidden" name="id" value="{{ $region->id }}">
                            <div class="col-md-6">
                                <label for="country_name" class="form-label">Country Name</label>
                                <select name="country_name" id="country_name" class="form-control" onchange="getStates(this.value)">
                                    <option value="">Select State</option>
                                    @if(!empty($countries))
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" @selected($country->id ==$region->country_id)>{{ ucfirst($country->name) }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <div class="country_name-error"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="state_name" class="form-label">State Name</label>
                                <select name="state_name" id="state_name" class="form-control" >
                                    <option value="">Select State</option>
                                    @if ($states->count() >0)
                                        @foreach ($states as $state)
                                            <option value="{{ $state->id }}" @selected($state->id == $region->state_id)>{{ ucfirst($state->name) }}</option>
                                        @endforeach   
                                    @endif
                                </select>                               
                                <div class="state_name-error"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="state_name" class="form-label">Region Name</label>
                                <input type="text" name="region_name" id="region_name" class="form-control" value="{{ ucfirst($region->name) }}">                            
                                <div class="region_name-error"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary m-3">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
 <!-- / Content -->
@endsection
@push('js')
    <script src="{{ asset('admin-auth-assets/js/custom/destination/region.js') }}"></script>
@endpush