@extends('frontend.layouts.master')
@push('css')
<!-- Fancybox CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/css/lightgallery.min.css">
<!-- Flatpickr Date Picker CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@push('div_start')
<div class="innerheader">
    @endpush
    @push('div_end')
</div>
@endpush
@section('css1')
<style>
    /* Captcha block (inquiry form) */
    .captcha-label {
        display: block;
        font-weight: 600;
        font-size: 13px;
        color: #374151;
        margin-bottom: 6px;
        letter-spacing: 0.2px;
    }
    .captcha-box {
        display: flex;
        align-items: stretch;
        gap: 10px;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 10px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04);
        flex-wrap: wrap;
    }
    .captcha-image-wrap {
        flex: 0 0 auto;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 4px 10px;
        min-height: 52px;
    }
    .captcha-image-wrap img#captcha-image {
        display: block;
        height: 44px;
        max-width: 100%;
        cursor: pointer;
    }
    .captcha-refresh {
        flex: 0 0 auto;
        width: 42px;
        height: 42px;
        align-self: center;
        border: 0;
        border-radius: 50%;
        background: #2563eb;
        color: #fff;
        font-size: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.3);
        transition: transform 0.4s ease, background 0.15s ease;
    }
    .captcha-refresh:hover {
        background: #1d4ed8;
        transform: rotate(180deg);
    }
    .captcha-input {
        flex: 1;
        min-width: 0;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: #fff;
        padding: 10px 14px;
        font-size: 14px;
        font-weight: 500;
        letter-spacing: 1px;
        color: #111827;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }
    .captcha-input:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }
    .captcha-input::placeholder {
        font-weight: 400;
        letter-spacing: 0.3px;
        color: #9ca3af;
    }

    .navigation {
        position: relative;
        z-index: 99;
        width: 100%;
        background: var(--theme-color);
        border-radius: 20px;
        border-top: 2px solid #fefefe;
    }
</style>
@endsection
@section('content')
<section class="area-searching destination-search">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="breadcrumb____titles">
                    <h1>{{ $propertyDetail?->property_name }}</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="breadcrumb inner-breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <ul>
                    @if($propertyDetail?->country)
                        <li>
                            <a href="{{ route('property.listing', ['country_id' => $propertyDetail?->country_id, 'state_id' => $propertyDetail?->state_id, 'type' => 'state']) }}">
                                {{ $propertyDetail?->country?->name }}
                            </a>
                        </li>
                    @endif

                    @if($propertyDetail->state)
                        <li>
                            <a href="{{ route('property.listing', ['country_id' => $propertyDetail->country_id, 'state_id' => $propertyDetail->state_id, 'type' => 'state']) }}">
                                {{ $propertyDetail->state->name }}
                            </a>
                        </li>
                    @endif

                    @if($propertyDetail->region)
                        <li>
                            <a href="{{ route('property.listing', ['country_id' => $propertyDetail->country_id, 'state_id' => $propertyDetail->state_id, 'region_id' => $propertyDetail->region_id, 'type' => 'region']) }}">
                                {{ $propertyDetail->region->name }}
                            </a>
                        </li>
                    @endif

                    @if($propertyDetail->city)
                        <li>
                            <a href="{{ route('property.listing', ['country_id' => $propertyDetail->country_id, 'state_id' => $propertyDetail->state_id, 'region_id' => $propertyDetail->region_id, 'city_id' => $propertyDetail->city_id, 'type' => 'city']) }}">
                                {{ $propertyDetail->city->name }}
                            </a>
                        </li>
                    @endif

                    @if($propertyDetail->subCity)
                        <li>
                            <a href="{{ route('property.listing', ['country_id' => $propertyDetail->country_id, 'state_id' => $propertyDetail->state_id, 'region_id' => $propertyDetail->region_id, 'city_id' => $propertyDetail->city_id, 'sub_city_id' => $propertyDetail->sub_city_id, 'type' => 'sub_city']) }}">
                                {{ $propertyDetail->subCity->name }}
                            </a>
                        </li>
                    @endif

                    <li><a href="javascript:void(0)">Listing id {{ $propertyDetail->id }}</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="gray-bg">
    <div class="container">

        <div class="row">
            <div class="col-sm-8 col-md-8 col-lg-8">
                <div class="row">
                      <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="inner__details__sliders">
                            <!-- Main Slider -->
                            <div class="main-slider" id="lightgallery-main">
                                @foreach ($propertyDetail->galleryImage as $images)
                                    <div data-src="{{env('IMAGE_URL')}}/upload/property_image/gallery_image/{{ $images->property_id }}/{{ $images->image_name }}">
                                        <img src="{{env('IMAGE_URL')}}/upload/property_image/gallery_image/{{ $images->property_id }}/{{ $images->image_name }}">
                                    </div>
                                @endforeach
                            </div>
                            <div class="slider__buttons__details">
                                <button class="slider-prev"><i class="fa fa-chevron-left"></i></button>
                                <button class="slider-next"><i class="fa fa-chevron-right"></i></button>
                            </div>
                            <!-- Thumbnails -->
                            <div class="thumbnail-slider">
                                @foreach ($propertyDetail->galleryImage as $images)
                                    <div data-src="{{env('IMAGE_URL')}}/upload/property_image/gallery_image/{{ $images->property_id }}/{{ $images->image_name }}">
                                        <img src="{{env('IMAGE_URL')}}/upload/property_image/gallery_image/{{ $images->property_id }}/{{ $images->image_name }}">
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="propertyname">
                            <h1><strong>{{ $propertyDetail->property_name }}</strong></h1>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div id="stiky-menu-bar" class="stiky-menu-bar2 mt-2">
                            <ul class="stiky-menu hidden-sm">
                                <li><a href="#overview" data-target="overview">Overview</a></li>
                                <li><a href="#amenity" data-target="amenity">Amenities</a></li>
                                <li><a href="#rate" data-target="rate">Rates</a></li>
                                <li><a href="#availability" data-target="availability">Availability</a></li>
                                <li><a href="#location" data-target="location">Location</a></li>
                                <li><a href="#reviews" data-target="reviews">Reviews</a></li>
                                <li><a href="#owner" data-target="owner">Owner Info</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="information section-break " id="overview">
                            <div class="general-info">
                                <ul>
                                    <li><img height="25" width="25" src="{{ asset('frontend-assets/images/home.png') }}">{{ $propertyDetail->propertyType->name }}</li>
                                    <li><img height="25" width="25" src="{{ asset('frontend-assets/images/sleeps.png') }}">Sleeps: {{ $propertyDetail->sleeps }}</li>
                                    <li><img height="25" width="25" src="{{ asset('frontend-assets/images/bed.png') }}">Bedrooms: {{ $propertyDetail->bedrooms }}</li>
                                    <li><img height="25" width="25" src="{{ asset('frontend-assets/images/bath.png') }}">Bathrooms: {{ $propertyDetail->bathrooms }}</li>
                                    {{-- <li><img height="25" width="25" src="{{ asset('frontend-assets/images/min-stay.png') }}">Min Stay: 7</li> --}}
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="section-break topicheading">
                            <h2>Description</h2>
                            {!! $propertyDetail->description !!}
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="section-break topicheading" id="amenity">
                            <h2>Amenities</h2>
                            @foreach ($propertyDetail->aminities as $mainAminity)
                            <div class="sub__title__amenities">{{ucfirst($mainAminity->aminities->name)}}</div>
                            <ul class="amenity-list">
                                @foreach (App\Http\Helper\Helper::getSubAmenites($mainAminity->amenites_id,$mainAminity->property_id) as $subAminity)
                                @if (count(App\Http\Helper\Helper::getChildAmenites($subAminity->sub_amenites_id,$subAminity->property_id))>0)
                                @foreach (App\Http\Helper\Helper::getChildAmenites($subAminity->sub_amenites_id,$subAminity->property_id) as $childAmenites)

                                    <li>
                                        <div>
                                            <span class="icons__inner"><i class="bi bi-clipboard-check-fill"></i></span> <span class="amenities__content">{{ ucfirst($childAmenites->child_amenities->name)  }}</span>
                                        </div>
                                    </li>
                                    @endforeach
                                    @else
                                    <li>
                                        <div>
                                            <span class="icons__inner"><i class="bi bi-clipboard-check-fill"></i></span> <span class="amenities__content">{{ ucfirst($subAminity->sub_amenities->name) }}</span>
                                        </div>
                                    </li>
                                @endif
                                @endforeach
                            </ul>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="section-break topicheading" id="rate">
                            <h2>Rates</h2>
                            <div class="table-responsive">
                                <table class="table table-bordered mar-0">
                                    <thead style="background: #113D48; color: #fefefe;">
                                        <tr>
                                            <td width=""><b>Season</b></td>
                                            <td><b>Nightly</b></td>
                                            <td><b>Weekly</b></td>
                                            <td><b>Weekend</b></td>
                                            <td><b>Monthly</b></td>
                                            <td><b>Minimum Stay</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($propertyDetail->propertyRates as $propertyRates)
                                        <tr>
                                            <td><b class="font-600">{{ $propertyRates->session_name }}</b> <br> {{ \Carbon\Carbon::parse($propertyRates->start_date)->format('F jS Y') }} - {{ \Carbon\Carbon::parse($propertyRates->end_date)->format('F jS Y') }}</td>
                                            <td> ${{ $propertyRates->nightly_rate }} </td>
                                            <td> @if($propertyRates->weekly_rate !=null) ${{ $propertyRates->weekly_rate  }} @else - @endif </td>
                                            <td> @if($propertyRates->weekend_rate !=null) ${{ $propertyRates->weekend_rate  }} @else - @endif </td>
                                            <td> @if($propertyRates->monthly_rate !=null) ${{ $propertyRates->monthly_rate  }} @else - @endif </td>
                                            <td>{{ $propertyRates->minimum_stay }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="additional-rates">
                                <h5>Additional information about rental rates</h5>
                                <ul class="list-inline">
                                    @if($propertyDetail->cleaning_fees !=null) <li> Cleaning fee <span>${{ $propertyDetail->cleaning_fees }}</span></li> @endif
                                    @if($propertyDetail->refundable_damage_deposite !=null) <li> Refundable damage deposit <span>${{ $propertyDetail->refundable_damage_deposite }}</span> </li> @endif
                                    @if($propertyDetail->admin_fees !=null) <li> Admin Fee <span>${{ $propertyDetail->admin_fees }}</span> </li> @endif
                                    @if($propertyDetail->danage_waiver !=null) <li> Damage Waiver Fee <span>${{ $propertyDetail->danage_waiver }}</span> </li> @endif
                                    @if($propertyDetail->pet_fee !=null) <li>Pet Fee <span>${{ $propertyDetail->pet_fee }}</span> </li> @endif
                                    @if($propertyDetail->extra_person_fee !=null) <li>Extra Person Fee <span>${{ $propertyDetail->extra_person_fee }}</span> </li> @endif
                                    @if($propertyDetail->extra_person_fee !=null) <li>Extra Person Fee <span>${{ $propertyDetail->extra_person_fee }}</span> </li> @endif
                                    @if($propertyDetail->poolheating_fee !=null) <li>Pool Heating Fee <span>${{ $propertyDetail->poolheating_fee }}</span> </li> @endif
                                    @if($propertyDetail->tax_rates !=null) <li>Tax Rates <span>{{ $propertyDetail->tax_rates }} %</span> </li> @endif
                                </ul>
                            </div>

                            @if($propertyDetail->rates_notes !=null)
                            <div class="rental-notes-section mt-3">
                                <h5>Rental Notes</h5>
                                <div class="rental-notes-content">
                                    {!! $propertyDetail->rates_notes !!}
                                </div>
                            </div>
                            @endif

                            @if($propertyDetail->rental_policies || $propertyDetail->upload_rental_policies)
                            <div class="rental-notes-section mt-3">
                                <h5>Rental Policies</h5>
                                @if($propertyDetail->rental_policies)
                                    <div class="rental-notes-content">{!! nl2br(e($propertyDetail->rental_policies)) !!}</div>
                                @endif
                                @if($propertyDetail->upload_rental_policies)
                                    <p class="mt-2">
                                        <a href="{{ url('storage/upload/rental_policies/'.$propertyDetail->upload_rental_policies) }}" target="_blank" rel="noopener">
                                            <i class="fa fa-file-text-o"></i> Download Rental Agreement
                                        </a>
                                    </p>
                                @endif
                            </div>
                            @endif

                            @if($propertyDetail->cancel_polices || $propertyDetail->upload_cancel_policies)
                            <div class="rental-notes-section mt-3">
                                <h5>Cancellation Policies</h5>
                                @if($propertyDetail->cancel_polices)
                                    <div class="rental-notes-content">{!! nl2br(e($propertyDetail->cancel_polices)) !!}</div>
                                @endif
                                @if($propertyDetail->upload_cancel_policies)
                                    <p class="mt-2">
                                        <a href="{{ url('storage/upload/rental_policies/'.$propertyDetail->upload_cancel_policies) }}" target="_blank" rel="noopener">
                                            <i class="fa fa-file-text-o"></i> Download Cancellation Agreement
                                        </a>
                                    </p>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="section-break topicheading" id="availability">
                            <h2>Availability</h2>
                            <div class="calender__buttons">
                                <button onclick="prevMonth()">Prev</button>
                                <button onclick="refreshCalendar()">Refresh</button>
                                <button onclick="nextMonth()">Next</button>
                            </div>
                            <div class="calendar-container">
                                <div class="calendar" id="calendar1"></div>
                                <div class="calendar" id="calendar2"></div>
                            </div>
                            <div class="calendar-legend" style="display: flex; gap: 20px; flex-wrap: wrap; margin-top: 15px; padding: 10px; align-items: center;">
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <span style="display: inline-block; width: 24px; height: 24px; background-color: #e74c3c; border: 1px solid #ccc;"></span>
                                    <span>Booked</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <span style="display: inline-block; width: 24px; height: 24px; background: linear-gradient(to bottom left, #3498db 50%, transparent 50%); border: 1px solid #ccc;"></span>
                                    <span>Check-In</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <span style="display: inline-block; width: 24px; height: 24px; background: linear-gradient(to top right, #f39c12 50%, transparent 50%); border: 1px solid #ccc;"></span>
                                    <span>Check-Out</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <span style="display: inline-block; width: 24px; height: 24px; background: linear-gradient(to top right, #f39c12 50%, #3498db 50%); border: 1px solid #ccc;"></span>
                                    <span>Check-Out / Check-In</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <span style="display: inline-block; width: 24px; height: 24px; background-color: yellow; border: 1px solid #ccc;"></span>
                                    <span>Today</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="section-break topicheading" id="location">
                            <h2>Google Location</h2>
                           @if($propertyDetail->address !=null || $propertyDetail->latitude !=null ||$propertyDetail->longitude !=null)
                                <div id="maps" style="width: 100%;height:600px"></div>
                            @elseif($propertyDetail->iframe_link !=null )
                                <iframe src="{{ $propertyDetail->iframe_link }}" width="100%" height="300" frameborder="0" allowfullscreen="" aria-hidden="false" tabindex="0" style="border: 0px;"></iframe>
                            @endif
                        </div>
                    </div>

                    @if($propertyDetail->extrnal_link !=null)
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="section-break topicheading">
                            <h2><i class="bi bi-camera-video-fill"></i> Video / Virtual Tour</h2>
                            <div class="virtual-tour-video-wrapper">
                                @php
                                    $videoUrl = $propertyDetail->extrnal_link;
                                    $embedUrl = '';
                                    if(preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $videoUrl, $matches)) {
                                        $embedUrl = 'https://www.youtube.com/embed/' . $matches[1] . '?autoplay=1&mute=1';
                                    } elseif(preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $videoUrl, $matches)) {
                                        $embedUrl = 'https://player.vimeo.com/video/' . $matches[1] . '?autoplay=1&muted=1';
                                    }
                                @endphp
                                @if($embedUrl)
                                    <iframe src="{{ $embedUrl }}" width="100%" height="450" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="border-radius: 10px;"></iframe>
                                @else
                                    <a href="{{ $videoUrl }}" target="_blank" rel="noopener noreferrer" class="virtual-tour-btn">
                                        <i class="bi bi-play-circle"></i> Watch Now
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="section-break topicheading" id="reviews">
                            <div class="row" style="position: relative;">
                                <div class="col-md-6">
                                    <h2>Reviews</h2>
                                </div>
                                <div class="col-md-6"><a href="#" class="reviewbutton">Write a Review</a></div>
                            </div>
                            <div class="comment-content">
                                @foreach ($propertyDetail->propertyReviews as $reviews)
                                    <div class="row p-2">
                                        <div class="col-md-3 col-sm-3">
                                            <div class="comment-image">
                                                <img src="{{ asset('frontend-assets/images/default-user.jpg') }}" alt="Images">
                                                <h4><a href="#">{{ $reviews->guest_name }}</a></h4>
                                            </div>
                                        </div>
                                        <div class="col-md-9 col-sm-9">
                                            <div class="comment-desc">
                                                <h5 class="review-heading">{{ $reviews->reviews_heading ?? 'Guest Review' }}</h5>
                                                <div class="comment-rate-time">
                                                    <div class="deal-rating">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($reviews->rating >=$i)
                                                            <span class="fa fa-star checked"></span>
                                                        @else
                                                            <span class="fa fa-star-o"></span>
                                                        @endif
                                                    @endfor
                                                </div>
                                                </div>
                                                <p>{!! $reviews->reviews !!} </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-md-4 col-lg-4 form-box">
                <!-- OWNER CARD -->
                <div class="owner-card mb-3">
                    @if($propertyDetail?->user?->userInformation?->profile_pic !=null)
                        <img src="{{env('IMAGE_URL')}}/upload/profile_image/{{ $propertyDetail?->user?->userInformation?->profile_pic }}" class="owner-img" alt="Owner Photo">
                    @else
                        <img src="{{ asset('frontend-assets/images/1.jpg') }}" class="owner-img" alt="Default Owner Photo">
                    @endif
                    <h3 class="owner-name">{{ $propertyDetail?->user->id !='1' ? $propertyDetail?->user?->name : "Home Owner" }}</h3>
                    @if($propertyDetail->personal_website_link !=null)
                        <a href="{{ $propertyDetail->personal_website_link }}" target="_blank" rel="noopener noreferrer" class="personal-website-link">
                            <i class="bi bi-globe"></i> Visit Personal Website
                        </a>
                    @endif
                </div>

                <aside class="detail-sidebar sidebar-wrapper">
                    <div class="sidebar-item sidebar-item-dark">
                        <div class="detail-title">
                            <h3>Inquire Now</h3>
                        </div>
                        <div id="inquiry-alert" style="display:none;" class="alert"></div>
                        <form id="inquiryForm">
                            <input type="hidden" name="property_id" value="{{ $propertyDetail->id }}">
                            <div class="row">
                                <div class="form-group col-sm-6 p-1">
                                    <input type="text" name="first_name" class="form-control" placeholder="First Name." required>
                                    <small class="text-danger error-first_name"></small>
                                </div>
                                <div class="form-group col-sm-6 p-1">
                                    <input type="text" name="last_name" class="form-control" placeholder="Last Name." required>
                                    <small class="text-danger error-last_name"></small>
                                </div>
                                <div class="form-group col-sm-12 p-1">
                                    <input type="tel" name="phone" class="form-control" placeholder="Phone No." required>
                                    <small class="text-danger error-phone"></small>
                                </div>
                                <div class="form-group col-sm-12 p-1">
                                    <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                                    <small class="text-danger error-email"></small>
                                </div>
                                <div class="form-group col-sm-6 p-1">
                                    <label for="checkin">Check In</label>
                                    <input type="text" name="checkin" class="form-control" id="checkin" placeholder="Arrival date" readonly>
                                </div>

                                <div class="form-group col-sm-6 p-1">
                                    <label for="checkout">Check Out</label>
                                    <input type="text" name="checkout" class="form-control" id="checkout" placeholder="Departure date" readonly>
                                </div>

                                <div class="form-group col-sm-6 p-1">
                                    <select name="adults" class=" form-control">
                                        <option value="0">Adult</option>
                                        <option value="1">Adult 1</option>
                                        <option value="2">Adult 2</option>
                                        <option value="3">Adult 3</option>
                                        <option value="4">Adult 4</option>
                                        <option value="5">Adult 5</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6 p-1">
                                    <select name="children" class=" form-control">
                                        <option value="0">Child</option>
                                        <option value="1">Child 1</option>
                                        <option value="2">Child 2</option>
                                        <option value="3">Child 3</option>
                                        <option value="4">Child 4</option>
                                        <option value="5">Child 5</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-12">
                                    <textarea name="message" id="message" class="form-control mt-3" placeholder="Write message here..."></textarea>
                                </div>
                                <div class="form-group col-sm-12 p-1">
                                    <label class="captcha-label">Verify you're human</label>
                                    <div class="captcha-box">
                                        <div class="captcha-image-wrap">
                                            <img id="captcha-image" src="{{ captcha_src('flat') }}" alt="captcha" title="Click to refresh">
                                        </div>
                                        <button type="button" id="refreshCaptcha" class="captcha-refresh" title="Refresh captcha">
                                            <i class="fa fa-refresh"></i>
                                        </button>
                                        <input type="text" name="captcha" class="captcha-input" placeholder="Type the code above" required autocomplete="off">
                                    </div>
                                    <small class="text-danger error-captcha"></small>
                                </div>
                                <div class="col-sm-12 p-1">
                                    <div class="comment-btn__inner">
                                        <button type="submit" id="inquirySubmitBtn">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>
@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/lightgallery.min.js"></script>
<script defer
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_KEY') }}&callback=initMap">
</script>
<script>
    function setVisibility(id) {
        if (document.getElementById('bt1').value == 'Show Less') {
            document.getElementById('bt1').value = 'Show More';
            document.getElementById(id).style.display = 'none';
        } else {
            document.getElementById('bt1').value = 'Show Less';
            document.getElementById(id).style.display = 'inline';
        }
    }
    try {

        function initMap() {
            let latitude = {{$propertyDetail->latitude}};
            let longitude = {{$propertyDetail->longitude}};
            let position = {
                lat: latitude,
                lng: longitude
            };
            console.log(position);
            var options = {
                center: position,
                zoom: 10,
            };
            map = new google.maps.Map(document.getElementById("maps"), options);
            // Marker
            marker = new google.maps.Marker({
                position: position,
                map: map,
                title: "{{ $propertyDetail->address }}",
            });
        }

    } catch (error) {
        console.log(error.message)
    }
</script>
<script>
    $(function() {
        $('.main-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: false,
            adaptiveHeight: true,
            autoplay: true,
            autoplaySpeed: 2000,
            asNavFor: '.thumbnail-slider',
            nextArrow: $('.slider-next'),
            prevArrow: $('.slider-prev')
        });

        $('.thumbnail-slider').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            asNavFor: '.main-slider',
            focusOnSelect: true,
            centerMode: true,
            centerPadding: '40px',
            infinite: true,
            autoplay: true,
            arrows: false,
            autoplaySpeed: 2000,
            responsive: [{
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 3
                    }
                }
            ]
        });

        // LightGallery on Main Slider
        lightGallery(document.getElementById('lightgallery-main'), {
            selector: 'div',
            zoom: true,
            hash: true,
            videojs: true,
            download: false
        });
    });
</script>
<!-- Fancybox JS -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
<!-- Flatpickr Date Picker JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    let currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();
    const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

    const bookedDates = @json($bookedDates);

    // Build array of fully booked dates for flatpickr
    const disabledDates = Object.keys(bookedDates).filter(function(dateKey) {
        const status = bookedDates[dateKey];
        return status.includes('booked') && !status.includes('checkin') && !status.includes('checkout');
    });

    // Initialize Flatpickr date pickers
    const checkinPicker = flatpickr('#checkin', {
        dateFormat: 'Y-m-d',
        minDate: 'today',
        disable: disabledDates,
        onChange: function(selectedDates) {
            if (selectedDates.length > 0) {
                const nextDay = new Date(selectedDates[0]);
                nextDay.setDate(nextDay.getDate() + 1);
                checkoutPicker.set('minDate', nextDay);
                checkoutPicker.open();
            }
        }
    });

    const checkoutPicker = flatpickr('#checkout', {
        dateFormat: 'Y-m-d',
        minDate: 'today',
        disable: disabledDates
    });

    function generateCalendar(monthOffset, calendarId) {
        let date = new Date(currentYear, currentMonth + monthOffset, 1);
        let month = date.getMonth();
        let year = date.getFullYear();
        let firstDay = new Date(year, month, 1).getDay();
        let daysInMonth = new Date(year, month + 1, 0).getDate();

        let calendarHtml = `<h3>${date.toLocaleString('default', { month: 'long' })} ${year}</h3>`;
        calendarHtml += `<div class='days'>`;

        // Add day names
        dayNames.forEach(day => {
            calendarHtml += `<div class='day-name'>${day}</div>`;
        });

        for (let i = 0; i < firstDay; i++) {
            calendarHtml += `<div class='day'></div>`;
        }

        for (let day = 1; day <= daysInMonth; day++) {
            let dateKey = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            let className = bookedDates[dateKey] || '';

            if (year === currentDate.getFullYear() && month === currentDate.getMonth() && day === currentDate.getDate()) {
                className += ' current-date';
            }

            calendarHtml += `<div class='day ${className.trim()}'>${day}</div>`;
        }

        calendarHtml += `</div>`;
        document.getElementById(calendarId).innerHTML = calendarHtml;
    }

    function updateCalendars() {
        generateCalendar(0, "calendar1");
        generateCalendar(1, "calendar2");
    }

    function nextMonth() {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        updateCalendars();
    }

    function prevMonth() {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        updateCalendars();
    }

    function refreshCalendar() {
        currentDate = new Date();
        currentMonth = currentDate.getMonth();
        currentYear = currentDate.getFullYear();
        updateCalendars();
    }

    updateCalendars();
</script>
<script>
    $(document).ready(function() {
        // Refresh captcha image
        function refreshCaptcha() {
            $('#captcha-image').attr('src', '{{ captcha_src("flat") }}' + '?' + Date.now());
        }

        $('#refreshCaptcha, #captcha-image').on('click', function() {
            refreshCaptcha();
        });

        $('#inquiryForm').on('submit', function(e) {
            e.preventDefault();

            // Clear previous errors
            $('.text-danger').text('');
            $('#inquiry-alert').hide().removeClass('alert-success alert-danger');

            var $btn = $('#inquirySubmitBtn');
            $btn.prop('disabled', true).text('Sending...');

            $.ajax({
                url: "{{ route('property.inquiry') }}",
                type: "POST",
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#inquiry-alert').removeClass('alert-danger').addClass('alert-success')
                        .text(response.message).fadeIn();
                    $('#inquiryForm')[0].reset();
                    refreshCaptcha();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            $('.error-' + field).text(messages[0]);
                        });
                    } else {
                        var msg = xhr.responseJSON?.message || 'Something went wrong. Please try again.';
                        $('#inquiry-alert').removeClass('alert-success').addClass('alert-danger')
                            .text(msg).fadeIn();
                    }
                    refreshCaptcha();
                },
                complete: function() {
                    $btn.prop('disabled', false).text('Submit');
                }
            });
        });
    });
</script>
@endpush
