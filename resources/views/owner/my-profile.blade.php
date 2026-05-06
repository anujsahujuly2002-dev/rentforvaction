@extends('frontend.layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend-assets/css/dashboard.css') }}">
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
            <div class="das-title">My Profile</div>
            @include('owner.layouts.owner-navbar')
            <div class="row">

                <div class="col-xs-3"> <!-- required for floating -->
                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs tabs-left sideways">
                    <li class="active"><a href="#edit-profile" data-toggle="tab">Edit profile</a></li>
                    <li><a href="#photo" data-toggle="tab">Photo</a></li>
                    <li><a href="#account" data-toggle="tab">Owner Address</a></li>
                    <li><a href="#billing" data-toggle="tab">Billing Details</a></li>
                    <li><a href="#password" data-toggle="tab">Changes Password</a></li>
                  </ul>
                </div>

                <div class="col-xs-9">
                    <div class="ownerpannelogin dashboard-list-box">
                      <!-- Tab panes -->
                      <div class="tab-content dashboard-list-box-static">
                        <div class="tab-pane active" id="edit-profile">
                            <div class="small-title">Edit Profile</div>
                            <!-- Details -->
                            <form id="myProfile">
                                <div class="my-profile">
                                    <label>Your Name *</label>
                                    <input value="{{ Auth()->user()->name }}" type="text" name="name">
                                    <label>Phone Number *</label>
                                    <input value="{{ Auth()->user()->userInformation->phone??"" }}" type="text" placeholder="(123) 123-456" name="phone">
                                    <label>Alternate Phone Number *</label>
                                    <input value="{{ Auth()->user()->userInformation->alternate_phone??"" }}" type="text" placeholder="(123) 123-456" name="alternate_phone">
    
                                    <label>Email Address *</label>
                                    <input value="{{ Auth()->user()->email }}" type="text" name="email_address">
                                    <label>Alternate Email Address *</label>
                                    <input value="{{ Auth()->user()->userInformation->secondary_email??"" }}" type="text" name="alternate_email_address">
    
                                    <label>Your Bio *</label>
                                    <textarea name="notes" id="notes" cols="30" rows="10" name="about_you">{{ Auth()->user()->userInformation->about_you??"" }}</textarea>
                                </div>
                                <button type="submit" class="button">Save Changes</button>                            
                            </form>
                        </div>
                        <div class="tab-pane" id="photo">
                            <div class="small-title">Profile Photo</div>
                            <div class="row">
                                <div class="col-md-5">
                                    <!-- Avatar -->
                                    <form id="profilePhoto" enctype="multipart/form-data">
                                        <div class="edit-profile-photo">
                                            <img src="{{url('storage/upload/profile_image/'.Auth()->user()->userInformation->profile_pic??"") }}" alt="">
                                            <div class="change-photo-btn">
                                                <div class="photoUpload">
                                                    <span><i class="fa fa-upload"></i> Upload Photo</span>
                                                    <input type="file" class="upload" name="profile_image"/>
                                                </div>
                                            </div>
                                        </div>                                    
                                        <button type="submit" class="button">Upload Photo</button>
                                        <button class="button dark">Remove Photo</button>
                                    </form>
                                </div>
                                <div class="col-md-7">
                                <label>Owner Photo</label>
                                <p>Maecenas quis consequat libero, a feugiat eros. Nunc ut lacinia tortor morbi ultricies laoreet ullamcorper phasellus semper</p>                                    
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="account">
                            <div class="small-title">Owner Address</div>
                                <!-- Account Setting -->
                                <form id="ownerAddress">
                                    <div class="my-profile">
                                        <label class="margin-top-0">Street Address</label>
                                        <input type="text" name="street_address" value="{{ Auth()->user()->userInformation->address }}">
    
                                        <label>City</label>
                                        <input type="text" name="city" value="{{ Auth()->user()->userInformation->city }}">
    
                                        <label>State</label>
                                        <input type="text" name="state" value="{{ Auth()->user()->userInformation->state }}">
    
                                        <label>Country</label>
                                        <input type="text" name="country" value="{{ Auth()->user()->userInformation->country }}">
    
                                        <label>Zip Code</label>
                                        <input type="text" name="zip_code" value="{{ Auth()->user()->userInformation->zipcode }}">
                                        <button class="button" type="submit">Save</button>
                                    </div>                            
                                </form>
                            </div>
                            <div class="tab-pane" id="billing">
                                <div class="small-title">Billing Details</div>
                                <!-- Billing Details -->
                                <div class="my-profile">
                                    <label class="margin-top-0">Demo Fields</label>
                                    <input type="text">

                                    <button class="button">Save</button>
                                </div>                            
                            </div>
                            <div class="tab-pane" id="password">
                                <div class="small-title">Changes Password</div>
                                <!-- Changes Password -->
                                <form id="changePassword">
                                    <div class="my-profile">
                                        <label class="margin-top-0">Old Password</label>
                                        <input type="text" name="old_password">
                                        <span class="old_password text-danger"></span>
                                        <label class="margin-top-0">New Password</label>
                                        <input type="text"  name="new_password">
                                        <span class="new_password text-danger"></span>
                                        <label class="margin-top-0">Confirm New Password</label>
                                        <input type="text" name="confirm_new_password">
                                        <span class="confirm_new_password text-danger"></span>
                                        <button class="button" type="submit">Update</button>
                                    </div>                        
                                </form>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script src="{{ asset('frontend-assets/js/jpanelmenu.min.js') }}"></script>
<script src="{{ asset('frontend-assets/js/counterup.min.js') }}"></script>
<script src="{{ asset('frontend-assets/js/ownerJs/edit-profile.js') }}"></script>

    <script>
        function myFunction() {
            var x = document.getElementById("myTopnav");
            if (x.className === "topnav") {
                x.className += " responsive";
            } else {
                x.className = "topnav";
            }
        }
    </script> 
@endpush