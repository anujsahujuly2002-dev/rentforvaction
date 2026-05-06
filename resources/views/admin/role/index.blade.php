@extends('admin.layouts.master')
@section('title')
Role List
@endsection
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        @include("toaster.toaster")
        <div class="row">
            <div class="col-md-6">
                <h4 class="fw-bold py-3 mb-4">Role Manage</h4>
            </div>
            <div class="col-md-6">
                @can('role-create')
                <a href="{{ route('admin.role.create') }}" class="btn btn-primary text-right" style="float: right">Create Role</a>
                @endcan
            </div>
        </div>
        <!-- Basic Bootstrap Table -->
        <div class="card">
            {{-- <h5 class="card-header">Table Basic</h5> --}}
            <div class="table-responsive text-nowrap">
                <table class="table" id="role" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                        <th>Sr.No</th>
                        <th>Role Name</th>
                         <th>Permission </th>
                        {{--<th>Status</th> --}}
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
<script src="{{ asset('admin-auth-assets/js/custom/role.js') }}"></script>
@endpush