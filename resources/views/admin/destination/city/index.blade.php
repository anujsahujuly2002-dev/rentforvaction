@extends('admin.layouts.master')
@section('title')
City List
@endsection
@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    @include("toaster.toaster")
    <div class="row">
        <div class="col-md-6">
            <h4 class="fw-bold py-3 mb-4">City Manage</h4>
        </div>
        <div class="col-md-6">
            @can('state-create')
            <a href="{{ route('admin.destination.city.create') }}" class="btn btn-primary text-right" style="float: right">Create City</a>
            @endcan
        </div>
    </div>
    <!-- Basic Bootstrap Table -->
    <div class="card">
        {{-- <h5 class="card-header">Table Basic</h5> --}}
        <div class="table-responsive text-nowrap">
            <table class="table" id="city" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                    <th>Sr.No</th>
                    <th>Country Name</th>
                    <th>State Name</th>
                    <th>Region Name</th>
                    <th>City Name</th>
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
    <script src="{{ asset('admin-auth-assets/js/custom/destination/city.js') }}"></script>
@endpush