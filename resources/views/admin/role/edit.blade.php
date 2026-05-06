@extends('admin.layouts.master')
@section('title')
Role Update
@endsection
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        @include("toaster.toaster")
        <div class="row">
            <div class="col-md-6">
                <h4 class="fw-bold py-3 mb-4">Role Update</h4>

            </div>
            <div class="col-md-6">
                <a href="{{ route('admin.role.list') }}" class="btn btn-primary text-right" style="float: right">Back</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form id="role-edit">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                @csrf
                                <div class="col-md-6">
                                    <input type="hidden" name="id" value="{{ $role->id }}">
                                    <label for="role-name" class="form-label">Role Name</label>
                                    <input type="text" class="form-control" id="role-name" placeholder="Role Name" name="role_name" value="{{ $role->name }}">
                                    <div class="role-name-error"></div>
                                </div>
                                <div class="col-md-6">
                                    {{-- <label for="permission_name" class="form-label">Permission Name</label>
                                    <input type="text" class="form-control" placeholder="Permission Group" name="permission_name" id="permission_name">
                                    <div class="permission-name-error"></div> --}}
                                </div>
                                <div class="col-md-12">
                                    <label for="permission_name" class="form-label">Permission</label>
                                    <div class="row">
                                        @if (!empty($permission))
                                            @foreach ($permission as $key => $perval)
                                            <div class="col-md-2">
                                                <small class="text-light fw-semibold d-block">{{ ucfirst($key) }}</small>
                                                @foreach ($perval as $per)
                                                <div class="form-check form-check-inline mt-3">
                                                    <input class="form-check-input" type="checkbox" name="permission_id[]" value="{{ $per->id }}"  id="per{{ $per->id }}"  {{ isset($rolePermissions[$per->id]) ? 'checked' : '' }}/>
                                                    <label class="form-check-label" for="per{{ $per->id }}" style="margin: 0px;">{{ ucfirst(str_replace("-"," ",$per->name)) }}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                            @endforeach
                                        @endif
                                    </div>
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
<script src="{{ asset('admin-auth-assets/js/custom/role.js') }}"></script>
@endpush