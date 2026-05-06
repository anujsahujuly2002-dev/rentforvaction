@extends('admin.layouts.master')
@section('title')
Country List
@endsection
@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    @include("toaster.toaster")
    <div class="row">
        <div class="col-md-6">
            <h4 class="fw-bold py-3 mb-4">Country Manage</h4>
        </div>
        <div class="col-md-6">
            @can('country-create')
            <a href="{{ route('admin.destination.country.create') }}" class="btn btn-primary text-right" style="float: right">Create Country</a>
            @endcan
        </div>
    </div>
    <!-- Basic Bootstrap Table -->
    <div class="card">
        {{-- <h5 class="card-header">Table Basic</h5> --}}
        <div class="table-responsive text-nowrap">
            <table class="table" id="country" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                    <th>Sr.No</th>
                    <th>Country Name</th>
                    <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->
</div>
 <!-- / Content -->
@endsection
@push('js')
    <script src="{{ asset('admin-auth-assets/js/custom/destination/country.js') }}"></script>
@endpush