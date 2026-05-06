@extends('admin.layouts.master')
@section('title')
Staff Create
@endsection
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        @include("toaster.toaster")
        <div class="row">
            <div class="col-md-6">
                <h4 class="fw-bold py-3 mb-4">Staff Create</h4>

            </div>
            <div class="col-md-6">
                <a href="{{ route('admin.staff.list') }}" class="btn btn-primary text-right" style="float: right">Back</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form id="staff-create">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                @csrf
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Name" name="name">
                                    <div class="name-error"></div>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" placeholder="" name="email" id="email">
                                    <div class="email-error"></div>
                                </div>
                                <div class="col-md-6">
                                    <label for="role" class="form-label">Role</label>
                                    <select id="role" class="form-select" name="role">
                                        <option value="">Select Role</option>
                                        @if(!empty($roles))
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <div class="role-error"></div>
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
<script src="{{ asset('admin-auth-assets/js/custom/staff.js') }}"></script>
@endpush