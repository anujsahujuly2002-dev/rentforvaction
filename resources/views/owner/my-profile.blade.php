@extends('frontend.layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend-assets/css/dashboard.css') }}">
    <style>
        /* Circular profile photo design (scoped to #photo tab) */
        #photo .profile-photo-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        #photo .profile-photo-circle {
            position: relative;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid #fff;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
            background: #f3f4f6;
            margin-bottom: 22px;
        }
        #photo .profile-photo-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            border-radius: 50%;
            max-width: none;
        }
        #photo .profile-photo-placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            font-size: 56px;
            background: #f3f4f6;
        }
        #photo .profile-photo-center-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: rgba(37, 99, 235, 0.92);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
            border: 3px solid #fff;
            pointer-events: none;
            z-index: 2;
        }
        #photo .profile-photo-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.25s ease;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }
        #photo .profile-photo-overlay i {
            font-size: 26px;
            margin-bottom: 4px;
        }
        #photo .profile-photo-circle:hover .profile-photo-overlay {
            opacity: 1;
        }
        #photo .profile-photo-overlay input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
        }
        #photo .profile-photo-filename {
            font-size: 13px;
            color: #6b7280;
            min-height: 18px;
            margin-bottom: 14px;
            word-break: break-all;
            max-width: 220px;
        }
        #photo .profile-photo-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }
        #photo .profile-photo-info {
            background: #f9fafb;
            border-radius: 10px;
            padding: 18px 20px;
            border: 1px solid #eef0f3;
        }
        #photo .profile-photo-info label {
            font-weight: 600;
            color: #111827;
            margin-bottom: 6px;
            display: block;
        }
        #photo .profile-photo-info p {
            color: #6b7280;
            margin: 0;
            line-height: 1.6;
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
            <div class="das-title">My Profile</div>
            @include('owner.layouts.owner-navbar')
            <div class="row">

                <div class="col-xs-3"> <!-- required for floating -->
                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs tabs-left sideways" role="tablist">
                    <li class="nav-item" role="presentation"><a class="nav-link active" data-bs-toggle="tab" href="#edit-profile" role="tab">Edit profile</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" data-bs-toggle="tab" href="#photo" role="tab">Photo</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" data-bs-toggle="tab" href="#account" role="tab">Owner Address</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" data-bs-toggle="tab" href="#billing" role="tab">Billing Details</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" data-bs-toggle="tab" href="#password" role="tab">Changes Password</a></li>
                  </ul>
                </div>

                <div class="col-xs-9">
                    <div class="ownerpannelogin dashboard-list-box">
                      <!-- Tab panes -->
                      <div class="tab-content dashboard-list-box-static">
                        <div class="tab-pane fade show active" id="edit-profile" role="tabpanel">
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
                        <div class="tab-pane fade" id="photo" role="tabpanel">
                            <div class="small-title">Profile Photo</div>
                            <div class="row align-items-center">
                                <div class="col-md-5">
                                    <form id="profilePhoto" enctype="multipart/form-data">
                                        <div class="profile-photo-wrap">
                                            <div class="profile-photo-circle">
                                                @php
                                                    $profilePic = Auth()->user()->userInformation->profile_pic ?? null;
                                                @endphp
                                                @if ($profilePic)
                                                    <img id="profilePhotoPreview" src="{{ url('storage/upload/profile_image/'.$profilePic) }}" alt="Profile photo">
                                                @else
                                                    <img id="profilePhotoPreview" src="" alt="Profile photo" style="display:none;">
                                                    <div class="profile-photo-placeholder" id="profilePhotoPlaceholder"></div>
                                                @endif
                                                <span class="profile-photo-center-icon" id="profilePhotoCenterIcon"><i class="fa fa-camera"></i></span>
                                                <label class="profile-photo-overlay" for="profilePhotoInput">
                                                    <i class="fa fa-camera"></i>
                                                    <span>Change Photo</span>
                                                    <input type="file" id="profilePhotoInput" name="profile_image" accept="image/png,image/jpeg,image/jpg,image/gif,image/webp"/>
                                                </label>
                                            </div>
                                            <div class="profile-photo-filename" id="profilePhotoFilename"></div>
                                            <div class="profile-photo-actions">
                                                <button type="submit" class="button">Upload Photo</button>
                                                <button type="button" class="button dark">Remove Photo</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-7">
                                    <div class="profile-photo-info">
                                        <label>Owner Photo</label>
                                        <p>Click the avatar (or the camera badge) to pick a new photo, then press <strong>Upload Photo</strong> to save it. JPG, PNG, GIF or WebP are accepted; square images look best.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account" role="tabpanel">
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
                            <div class="tab-pane fade" id="billing" role="tabpanel">
                                <div class="small-title">Billing Details</div>
                                <!-- Billing Details -->
                                <div class="my-profile">
                                    <label class="margin-top-0">Demo Fields</label>
                                    <input type="text">

                                    <button class="button">Save</button>
                                </div>                            
                            </div>
                            <div class="tab-pane fade" id="password" role="tabpanel">
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

        // Live preview of the picked profile photo
        (function () {
            var input = document.getElementById('profilePhotoInput');
            var preview = document.getElementById('profilePhotoPreview');
            var placeholder = document.getElementById('profilePhotoPlaceholder');
            var centerIcon = document.getElementById('profilePhotoCenterIcon');
            var filename = document.getElementById('profilePhotoFilename');
            if (!input || !preview) return;
            // If a saved photo is already present, hide the centered camera icon.
            if (preview.getAttribute('src')) {
                if (centerIcon) centerIcon.style.display = 'none';
            }
            input.addEventListener('change', function () {
                var file = this.files && this.files[0];
                if (!file) return;
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
                if (placeholder) placeholder.style.display = 'none';
                if (centerIcon) centerIcon.style.display = 'none';
                if (filename) filename.textContent = file.name;
            });
        })();
    </script>
@endpush