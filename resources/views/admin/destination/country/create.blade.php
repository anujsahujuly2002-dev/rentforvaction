@extends('admin.layouts.master')
@section('title')
Country Create
@endsection
@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    @include("toaster.toaster")
    <div class="row">
        <div class="col-md-6">
            <h4 class="fw-bold py-3 mb-4">Country Create</h4>

        </div>
        <div class="col-md-6">
            <a href="{{ route('admin.destination.country.index') }}" class="btn btn-primary text-right" style="float: right">Back</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form id="country-create">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            @csrf
                            <div class="col-md-6">
                                <label for="" class="form-label">Country Name</label>
                                <input type="text"  class="form-control" id="country_name" placeholder="Country Name" name="country_name" >
                                <div class="country_name-error"></div>
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
    <script src="{{ asset('admin-auth-assets/js/custom/destination/country.js') }}"></script>
@endpush