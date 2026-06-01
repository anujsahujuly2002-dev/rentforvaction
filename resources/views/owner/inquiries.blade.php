@extends('frontend.layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend-assets/css/dashboard.css') }}">
    <style>
        .inquiry-table th { background: #f8f9fa; font-weight: 600; }
        .inquiry-table td { vertical-align: middle; }
        .msg-cell { max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .badge-source { font-size: 11px; padding: 3px 8px; border-radius: 20px; }
        .badge-frontend { background: #e3f0ff; color: #1a6fc4; }
        .badge-owner    { background: #e8f5e9; color: #2e7d32; }
    </style>
@endpush
@push('div_start')
<div class="innerheader">
@endpush
@push('div_end')
</div>
@endpush
@section('content')

    <div class="dashboard-wrappermy pt-5">
        <div class="container">
            <div class="das-title">Inquiries</div>
            @include('owner.layouts.owner-navbar')

            <div class="property-mainsection mt-4">

                {{-- Filter bar --}}
                <form method="GET" action="{{ route('owner.inquiries') }}" class="mb-3 d-flex align-items-center gap-2" style="gap:10px;">
                    <select name="property_filter" class="form-control" style="max-width:280px;">
                        <option value="">All Properties</option>
                        @foreach($properties as $prop)
                            <option value="{{ $prop->id }}" {{ request('property_filter') == $prop->id ? 'selected' : '' }}>
                                {{ $prop->property_name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="button preview" style="padding:8px 18px;">Filter</button>
                    @if(request('property_filter'))
                        <a href="{{ route('owner.inquiries') }}" class="button" style="padding:8px 18px;">Clear</a>
                    @endif
                </form>

                @if($inquiries->isEmpty())
                    <div class="alert alert-info">No inquiries found.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered inquiry-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Property</th>
                                    <th>Guest</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Check-In</th>
                                    <th>Check-Out</th>
                                    <th>Guests</th>
                                    <th>Message</th>
                                    <th>Source</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inquiries as $i => $inq)
                                    <tr id="inq-row-{{ $inq->id }}">
                                        <td>{{ $inquiries->firstItem() + $i }}</td>
                                        <td>{{ $inq->property_name }}</td>
                                        <td>{{ $inq->first_name }} {{ $inq->last_name }}</td>
                                        <td>{{ $inq->email }}</td>
                                        <td>{{ $inq->phone }}</td>
                                        <td>{{ $inq->checkin ? date('M d, Y', strtotime($inq->checkin)) : '-' }}</td>
                                        <td>{{ $inq->checkout ? date('M d, Y', strtotime($inq->checkout)) : '-' }}</td>
                                        <td>{{ $inq->adults }}A / {{ $inq->children }}C</td>
                                        <td class="msg-cell" title="{{ $inq->message }}">{{ $inq->message ?: '-' }}</td>
                                        <td>
                                            <span class="badge-source badge-{{ $inq->source }}">{{ ucfirst($inq->source) }}</span>
                                        </td>
                                        <td>{{ $inq->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-danger delete-inquiry-btn"
                                                    data-id="{{ $inq->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $inquiries->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>

@endsection

@push('js')
<script>
$(function () {
    $(document).on('click', '.delete-inquiry-btn', function () {
        var id  = $(this).data('id');
        if (!confirm('Delete this inquiry?')) return;

        showloader();
        $.ajax({
            url: site_url + '/owner/delete-inquiry',
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { id: id },
            success: function (res) {
                hideLoader();
                if (res.status === 200) {
                    $('#inq-row-' + id).fadeOut(300, function () { $(this).remove(); });
                    toastr.success(res.msg);
                } else {
                    toastr.error(res.msg);
                }
            },
            error: function () {
                hideLoader();
                toastr.error('Something went wrong. Please try again.');
            }
        });
    });
});
</script>
@endpush
