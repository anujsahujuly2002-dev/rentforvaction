@extends('frontend.layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend-assets/css/dashboard.css') }}">
    <style>
        .table-box table.basic-table th, table.basic-table td{
            padding: 8px;
        }
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
            <div class="das-title">Property Information</div>
             @include('owner.layouts.owner-navbar')
            {{-- <div class="propertyInfo">
                <div class="row">
                    <div class="col-md-2"><img src="images/gallery/1.jpg" alt=""></div>
                    <div class="col-md-10">
                        <h1>Oceanfront Luxury Villa, Recently Renovated! Family/Couple getaway</h1>
                        <p>Cancun, Quintana Roo, Mexico</p>
                    </div>                            
                </div>
            </div> --}}
            <div class="property-mainsection">
                <div class="row">
                    @include('owner.property.left-sidebar')
                    <div class="col-md-10">
                        <div class="small-title">Property Reviews</div>
                        <div class="add-listing-section">
                            <div class="with-forms">
                                <form id="propertyReviews">
                                    <div class="row">
                                        <input type="hidden" name="property_id" value="{{ request()->id }}">
                                        <div class="col-md-6">
                                            <label for="reviews_heading">Reviews Heading</label>
                                            <input type="text" class="form-control" id="reviews_heading" name="reviews_heading">
                                            <span class="text-danger reviews_heading"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="guest_name">Guest Name</label>
                                            <input type="text" class="form-control" id="guest_name" name="guest_name">
                                            <span class="text-danger guest_name"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="place">Place</label>
                                            <input type="text" class="form-control" id="place" name="place">
                                            <span class="text-danger place"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="reviews">Reviews</label>
                                            <textarea class="form-control" id="reviews" name="reviews" rows="1"></textarea>
                                            <span class="text-danger reviews"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="rating">Rating</label>
                                            <select name="rating" id="rating" class="form-control">
                                                <option value="">Select Rating</option>
                                                @for($i=1;$i<=5;$i++)
                                                    <option value="{{ $i }}">{{ $i }} Star</option>
                                                @endfor
                                            </select>
                                            <span class="text-danger rating"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary add_reviews" style="margin-top:37px;">Add Reviews</button>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                                <div class="table-box">
                                    <table class="basic-table booking-table table-responsive" id="reviews-table">
                                        <thead>
                                            <tr>
                                                <th>Sr no.</th>
                                                <th>Reviews Heading</th>
                                                <th>Guest Name</th>
                                                <th>Place</th>
                                                <th>Reviews</th>
                                                <th>Rating</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 row" style="margin: 0px;">
                                        <button class="button preview next-step">Save &amp; Continue <i class="fa fa-arrow-circle-right"></i><button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>
                 {{-- model --}}
                 <div class="modal fade" id="editPropertyReviews" tabindex="-1" role="dialog" aria-labelledby="editPropertyReviewsLable" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editPropertyReviewsLable">Edit Rental Rates</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="editPropertyReviewsFrom">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" name="id" id="id">
                                        <div class="form-group">
                                            <label for="reviews_heading" class="col-form-label">Reviews Heading</label>
                                            <input type="text" class="form-control" id="reviews_heading" name="reviews_heading">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="guest_name" class="col-form-label">Guest Name:</label>
                                            <input type="text" name="guest_name" id="guest_name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="place" class="col-form-label">Place:</label>
                                            <input type="text" name="place" id="place">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="reviews" class="col-form-label">Reviews:</label>
                                            <input type="text" name="reviews" id="reviews">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rating" class="col-form-label">Rating:</label>
                                            <select name="rating" id="rating" class="form-control">
                                                <option value="">Select Rating</option>
                                                @for($i=1;$i<=5;$i++)
                                                    <option value="{{ $i }}">{{ $i }} Star</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-warning">Save changes</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('frontend-assets/js/ownerJs/property/reviews.js') }}"></script>
@endpush