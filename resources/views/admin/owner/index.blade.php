@extends('admin.layouts.master')
@section('title')
Manage Owners
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include("toaster.toaster")
        <div class="row">
            <div class="col-md-6">
                <h4 class="fw-bold py-3 mb-4">Manage Owners</h4>
            </div>
        </div>
        <div class="card">
            <div class="table-responsive text-nowrap">
                <table class="table" id="owner" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Total Properties</th>
                            <th>Approval</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('admin-auth-assets/js/custom/owner.js') }}"></script>
@endpush
