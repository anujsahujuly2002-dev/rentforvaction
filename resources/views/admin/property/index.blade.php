@extends('admin.layouts.master')
@section('title')
Property Manage
@endsection
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        @include("toaster.toaster")
        <div class="row">
            <div class="col-md-6">
                <h4 class="fw-bold py-3 mb-4">Property Manage</h4>
            </div>
            @can("property-create")
            <div class="col-md-6">
                <a href="{{ route('admin.property.create') }}" class="btn btn-primary text-right" style="float: right">Create Property</a>
            </div>
            @endcan
        </div>
        <!-- Basic Bootstrap Table -->
        <div class="card">
            {{-- <h5 class="card-header">Table Basic</h5> --}}
            <div class="text-nowrap">
                <table class="table" id="property-listing" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                        <th>Sr.No</th>
                        <th>Property Id</th>
                        <th>Property Name</th>
                        <th>No Of Enquiries</th>
                        <th>Subscription Date</th>
                        <th>Property Created Date</th>
                        <th>Renewal Date</th>
                        <th>No Visitors</th>
                        <th>Property Photo</th>
                        <th>Property Approved</th>
                        <th>Featured Property</th>
                        <th>Recommended</th>
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
<script src="{{ asset('admin-auth-assets/js/property/propertylist.js') }}"></script>
@endpush
