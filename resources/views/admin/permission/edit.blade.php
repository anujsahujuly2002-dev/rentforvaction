@extends('admin.layouts.master')
@section('title')
Permission Edit
@endsection
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        @include("toaster.toaster")
        <div class="row">
            <div class="col-md-6">
                <h4 class="fw-bold py-3 mb-4">Permission Edit</h4>

            </div>
            <div class="col-md-6">
                <a href="{{ route('admin.permission.list') }}" class="btn btn-primary text-right" style="float: right">Back</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form id="permission-edit">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                @csrf
                                <input type="hidden" value="{{ $permission->id }}" name="id">
                                <div class="col-md-6">
                                    <label for="permission-group" class="form-label">Permission Group</label>
                                    <input type="text" class="form-control" id="permission-group" placeholder="Permission Group" name="permission_group" value="{{ $permission->group }}">
                                    <div class="permission-group-error"></div>
                                </div>
                                <div class="col-md-6">
                                    <label for="permission_name" class="form-label">Permission Name</label>
                                    <input type="text" class="form-control" placeholder="Permission Group" name="permission_name" id="permission_name" value="{{ $permission->name }}">
                                    <div class="permission-name-error"></div>
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
<script src="{{ asset('admin-auth-assets/js/custom/permission.js') }}"></script>
@endpush