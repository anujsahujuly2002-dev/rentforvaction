@extends('frontend.layouts.master')
@section('css1')
<style>
    .navigation {
        position: absolute;
        z-index: 99;
        width: 100%;
        background: var(--theme-color);
        border-radius: 20px;
        border-top: 2px solid #fefefe;
    }
</style>
@endsection
@section('content')
<section class="area-searching destination-search main-contact-us">
    <div class="container">

        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="inner__desti__titles">
                    <h1>Book Now</h1>
                </div>
                <div class="breadcrumb-menu">
                    <ul class="custom-ul">
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li>Contact Us</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row mb-4">
            <div class="col-sm-12 col-md-12">
                <h2>Book Now</h2>
                <div class="comments-form detail-box">
                    <form>
                        <div class="row">
                            <div class="form-group col-sm-6 col-md-6">
                                <label for="Name">Locations:</label>
                                <select name="custom-select-2" class=" form-control">
                                        <option value="">Select Locations</option>
                                        <option value="1">Location 1</option>
                                        <option value="2">Location 2</option>
                                        <option value="3">Location 3</option>
                                        <option value="4">Location 4</option>
                                        <option value="5">Location 5</option>
                                    </select>
                            </div>
                            <div class="form-group col-sm-6 col-md-6">
                                <label for="mob">Mob:</label>
                                <input type="tel" class="form-control" id="mob" placeholder="000000000">
                            </div>
                            <div class="form-group col-sm-6 col-md-6">
                                <label for="email">Email address:</label>
                                <input type="email" class="form-control" id="email" placeholder="Enter Email....">
                            </div>
                            <div class="form-group col-sm-6 col-md-6">
                                <label for="date1">Check In:</label>
                               <input type="date" class="form-control" id="date1" placeholder="Arrival date">
                            </div>
                             <div class="form-group col-sm-6 col-md-6">
                                <label for="date2">Check Out:</label>
                               <input type="date" class="form-control" id="date2" placeholder="Departure date">
                            </div>
                                <div class="form-group col-sm-6 col-md-6">
                                    <label for="date2">Adults:</label>
                                    <select name="custom-select-2" class=" form-control">
                                        <option value="0">Adult</option>
                                        <option value="1">Adult 0</option>
                                        <option value="2">Adult 1</option>
                                        <option value="3">Adult 2</option>
                                        <option value="4">Adult 3</option>
                                        <option value="5">Adult 4</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6 col-md-6">
                                <label for="date2">Childs:</label>
                                    <select name="custom-select-2" class=" form-control">
                                        <option value="0">Child</option>
                                        <option value="1">Child 0</option>
                                        <option value="2">Child 1</option>
                                        <option value="3">Child 2</option>
                                        <option value="4">Child 3</option>
                                        <option value="5">Child 4</option>
                                    </select>
                                </div>
                            <div class="col-sm-12 col-md-12 mt-3 mb-3">
                                <div class="comment-btn__inner">
                                    <a href="#" class="btn-blue btn-red">Submit Now</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@push('js')

@endpush