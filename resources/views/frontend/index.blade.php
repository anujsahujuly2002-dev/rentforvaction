@extends('frontend.layouts.master')
@section('css1')
    <style>
        .navigation {
            background: transparent;
            backdrop-filter: blur(11px);
        }
    </style>
@endsection
@section('content')
    <!-- Paradise Slider -->
    <div id="mainCarouselSlide" class="carousel slide carousel-customes" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('frontend-assets/images/slider1.jpg') }}" class="d-block w-100" alt="...">
                <div class="carousel-caption carousel__caption">
                    <h5>Discover Your</h5>
                    <h2>Next Step <span>Destination</span></h2>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('frontend-assets/images/slider2.jpg') }}" class="d-block w-100" alt="...">
                <div class="carousel-caption carousel__caption">
                    <h5>Discover Your</h5>
                    <h2>Next Step <span>Destination</span></h2>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('frontend-assets/images/slider3.jpg') }}" class="d-block w-100" alt="...">
                <div class="carousel-caption carousel__caption">
                    <h5>Discover Your</h5>
                    <h2>Next Step <span>Destination</span></h2>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('frontend-assets/images/slider1.jpg') }}" class="d-block w-100" alt="...">
                <div class="carousel-caption carousel__caption">
                    <h5>Discover Your</h5>
                    <h2>Next Step <span>Destination</span></h2>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('frontend-assets/images/slider2.jpg') }}" class="d-block w-100" alt="...">
                <div class="carousel-caption carousel__caption">
                    <h5>Discover Your</h5>
                    <h2>Next Step <span>Destination</span></h2>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('frontend-assets/images/slider3.jpg') }}" class="d-block w-100" alt="...">
                <div class="carousel-caption carousel__caption">
                    <h5>Discover Your</h5>
                    <h2>Next Step <span>Destination</span></h2>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('frontend-assets/images/slider2.jpg') }}" class="d-block w-100" alt="...">
                <div class="carousel-caption carousel__caption">
                    <h5>Discover Your</h5>
                    <h2>Next Step <span>Destination</span></h2>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('frontend-assets/images/slider3.jpg') }}" class="d-block w-100" alt="...">
                <div class="carousel-caption carousel__caption">
                    <h5>Discover Your</h5>
                    <h2>Next Step <span>Destination</span></h2>
                </div>
            </div>
        </div>
        <div class="carousel__slide__btn">
            <button class="carousel-control-prev carousel-control-prev1" type="button" data-bs-target="#mainCarouselSlide"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next carousel-control-next1" type="button" data-bs-target="#mainCarouselSlide"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <!-- Banner Ends -->
    <!-- Search Box -->
    <div class="inner-booking-section d-md-block">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <form action="{{ route('property.listing') }}" method="GET" class="inner-booking-section2">
                        <input type="hidden" name="country_id" id="country_id">
                        <input type="hidden" name="state_id" id="state_id">
                        <input type="hidden" name="city_id" id="city_id">
                        <input type="hidden" name="sub_city_id" id="sub_city_id">
                        <input type="hidden" name="region_id" id="region_id">
                        <input type="hidden" name="type" id="search_type">
                        <input type="hidden" name="search_text" id="search_text">
                        <div class="row">
                            <div class="col-sm-4 col-md-4">
                                <div class="check-position mb-3">
                                    <div class="check-position mb-3 position-relative">
                                        <input type="text" id="search_destination" class="form-control form-control2" placeholder="Search Property ID or Location" autocomplete="off">
                                        <ul id="destination_list" class="list-group position-absolute w-100" style="z-index:1000;"></ul>
                                        <span><i class="bi bi-geo-alt-fill"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2 col-md-2">
                                <div class="mb-3 check-position">
                                    <!-- <label for="checkIn" class="form-label">Check In</label> -->
                                    <input type="text" id="checkIn" class="form-control form-control2"
                                        placeholder="check-in" readonly>
                                    <span><i class="bi bi-calendar2-week"></i></span>
                                </div>
                            </div>
                            <div class="col-sm-2 col-md-2">
                                <div class="mb-3 check-position">
                                    <!-- <label for="checkOut" class="form-label">Check Out</label> -->
                                    <input type="text" id="checkOut" class="form-control form-control2"
                                        placeholder="check-out" readonly>
                                    <span><i class="bi bi-calendar2-week"></i></span>
                                </div>
                            </div>
                            <div class="col-sm-2 col-md-2">
                                <div class="check-position mb-3">
                                    <select name="" id="" class="form-control form-control2" aria-describedby="basic-addon44">
                                        <option value="">Select Guest</option>
                                        @for($i = 1; $i <= 10; $i++)
                                            @if($i == 10)
                                                <option value="{{ $i }}" >{{ $i }}+</option>
                                            @else
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endif
                                        @endfor
                                    </select>
                                    <span><i class="bi bi-people-fill"></i></span>
                                </div>
                            </div>
                            <div class="col-sm-2 col-md-2">
                                <button class="check-availability" type="submit">Search <i class="bi bi-arrow-right-circle-fill"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Search Box Ends -->
    {{-- <section class="about-hrbo about-hrbo--two section-space">
        <div class="container">
            <div class="row gutter-y-40">
                <div class="col-lg-6 mt-2 mb-2">
                    <div class="about-hrbo__thumb wow fadeInLeft animated" data-wow-duration="1500ms"
                        data-wow-delay="300ms"
                        style="visibility: visible; animation-duration: 1500ms; animation-delay: 300ms; animation-name: fadeInLeft;">
                        <div class="google-map">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3113403.032786106!2d71.50259395166024!3d47.0176525942524!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x453c569a896724fb%3A0x1409fdf86611f613!2sRussia!5e1!3m2!1sen!2sin!4v1751277541335!5m2!1sen!2sin"
                                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-2">
                    <div class="about-hrbo__right">
                        <div class="hrbo___titles">
                            <p>About us</p>
                            <h4>Great Opportunity for Adventure & Travels</h4>
                        </div>
                        <p class="about-hrbo__top__text wow fadeInUp animated" data-wow-duration="1500ms"
                            data-wow-delay="300ms"
                            style="visibility: visible; animation-duration: 1500ms; animation-delay: 300ms; animation-name: fadeInUp;">
                            It is a long established fact that a reader will be distracted the readable content of a page
                            when looking at layout the point.</p>
                        <div class="about-hrbo__feature">
                            <div class="row gutter-y-20 gutter-x-20">
                                <div class="col-xl-6 col-lg-12 col-md-6 wow fadeInUp animated">
                                    <div class="about-hrbo__feature-vestion">
                                        <div class="about-hrbo__feature_icon">
                                            <i class="bi bi-shield-fill-plus"></i>
                                        </div>
                                        <div class="about-hrbo__feature-content">
                                            <h5 class="about-hrbo__feature-title">Trusted travel guide</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-12 col-md-6">
                                    <div class="about-hrbo__feature-vestion wow fadeInUp animated">
                                        <div class="about-hrbo__feature_icon">
                                            <i class="bi bi-shield-fill-check"></i>
                                        </div>
                                        <div class="about-hrbo__feature-content">
                                            <h5 class="about-hrbo__feature-title">Mission &amp; Vision</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="about-hrbo__button">
                            <a href="#" class="hrbo-btn hrbo-btn--primary">Discover More <span class="icon"><i
                                        class="bi bi-arrow-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="about-hrbo__element-one">
            <img src="{{ asset('frontend-assets/images/about/3.webp') }}" alt="">
        </div>
        <div class="about-hrbo__element-two">
            <img src="{{ asset('frontend-assets/images/about/4.webp') }}" alt="gotur image">
        </div>
    </section> --}}
    <section>
        <div class="container-xxl">
            <div class="row justify-content-center">
                <div class="col-sm-7 col-md-7 col-lg-7">
                    <div class="section_hrbo___titles">
                        <p>Featured</p>
                        <h2>Featured <span>Listing</span></h2>
                    </div>
                </div>
                <div class="col-sm-5 col-md-5 col-lg-5">
                    <button class="slider-prev1"><i class="fa fa-chevron-left"></i></button>
                    <button class="slider-next1"><i class="fa fa-chevron-right"></i></button>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="slicks-slider">
                        @foreach ($featuredProperties as $featureProperty)
                            <div class="item-list">
                                <div class="listing-card-four wow fadeInUp">
                                    <div class="listing-card-four__image">
                                        <img src="{{ env('IMAGE_URL') . '/upload/property_image/main_image/' . $featureProperty->property->property_image }}"
                                            alt="All Inclusive Ultimate Circle Island Day with Lunch">

                                        <div class="listing-card-four__btns">
                                            <p>Best Selling</p>
                                        </div>
                                        <a href="{{ route('property.details', ['id' => $featureProperty->property->id]) }}"
                                            class="listing-card-four__image__overly"></a>
                                    </div>
                                    <div class="listing-card-four__content">
                                        <div class="listing-card-four__rating">

                                        </div>
                                        <h3 class="listing-card-four__title"><a href="{{ route('property.details', ['id' => $featureProperty->property->id]) }}">{{ App\Http\Helper\Helper::limit_text($featureProperty->property->property_name, 6) }}</a>
                                        </h3>
                                        <p class="features-desti"><i class="bi bi-geo-alt-fill"></i>
                                            @php
                                                $locationParts = array_filter([
                                                    $featureProperty->property->country->name ?? null,
                                                    $featureProperty->property->state->name ?? null,
                                                    $featureProperty->property->region->name ?? null,
                                                    $featureProperty->property->city->name ?? null,
                                                    $featureProperty->property->subCity->name ?? null,
                                                ]);
                                            @endphp
                                            {{ implode(', ', $locationParts) }}
                                        </p>

                                        <div class="listing-card-four__content__btn">
                                            <div class="listing-card-four__price">
                                                <span
                                                    class="listing-card-four__price__sub">{{ $featureProperty->property->rate_per_unit }}</span>
                                                <span
                                                    class="listing-card-four__price__number">${{ $featureProperty->property->avg_night }}</span>
                                            </div>
                                            <a href="{{ route('property.details', ['id' => $featureProperty->property->id]) }}"class="listing-card-four__btn hrbo-btn"> View Details <span class="icon"><i class="bi bi-arrow-right"></i> </span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2 mb-4">
                    <a href="#" class="listing-card-four__btn hrbo-btn"> View more <span class="icon"><i class="bi bi-arrow-right"></i> </span></a>
                </div>
            </div>
        </div>
    </section>
    <section class="destination-filter">
        <div class="container-xxl">
            <div class="row justify-content-center">
                <div class="col-sm-7 col-md-7 col-lg-7">
                    <div class="section_hrbo___titles">
                        <p>Destination</p>
                        <h2>Popular <span>Destination</span></h2>
                    </div>
                </div>
                <div class="col-sm-5 col-md-5 col-lg-5">
                    <button class="slider-prev"><i class="fa fa-chevron-left"></i></button>
                    <button class="slider-next"><i class="fa fa-chevron-right"></i></button>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="wrapperss">
                        <div class="center-slider">
                            <div class="slide-item">
                                <div class="box-item-card">
                                    <a href="{{ route('property.listing', ['country_id' =>'1', 'state_id' => '2', 'type' => 'state']) }}">
                                        <div class="desti-image">
                                            <img src="{{ asset('frontend-assets/images/popular-destination/alaska.jpeg') }}" alt="Image">
                                        </div>
                                    </a>
                                </div>
                                <div class="destination-content">
                                    <a href="{{ route('property.listing', ['country_id' =>'1', 'state_id' => '2', 'type' => 'state']) }}">
                                        <h3>Alaska</h3>
                                        <div class="view___more"><span>View more</span><i class="bi bi-arrow-right"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="slide-item">
                                <div class="box-item-card">
                                    <a href="{{ route('property.listing', ['country_id' =>'1', 'state_id' => '21', 'type' => 'state']) }}">
                                        <div class="desti-image">
                                            <img src="{{ asset('frontend-assets/images/popular-destination/MA.jpeg') }}"alt="Image">
                                        </div>
                                    </a>
                                </div>
                                <div class="destination-content">
                                    <a href="{{ route('property.listing', ['country_id' =>'1', 'state_id' => '21', 'type' => 'state']) }}">
                                        <h3>Massachusetts </h3>
                                        <div class="view___more"><span>View more</span><i class="bi bi-arrow-right"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="slide-item">
                                <div class="box-item-card">
                                    <a href="{{ route('property.listing', ['country_id' =>'1', 'state_id' => '6', 'type' => 'state']) }}">
                                        <div class="desti-image">
                                            <img src="{{ asset('frontend-assets/images/popular-destination/CO.jpeg') }}" alt="Image">
                                        </div>
                                    </a>
                                </div>
                                <div class="destination-content">
                                    <a href="{{ route('property.listing', ['country_id' =>'1', 'state_id' => '6', 'type' => 'state']) }}">
                                        <h3>Colorado</h3>
                                        <div class="view___more"><span>View more</span><i class="bi bi-arrow-right"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="slide-item">
                                <div class="box-item-card">
                                    <a href="{{ route('property.listing', ['country_id' =>'1', 'state_id' => '38', 'type' => 'state']) }}">
                                        <div class="desti-image">
                                            <img src="{{ asset('frontend-assets/images/popular-destination/TN.jpeg') }}" alt="Image">
                                        </div>
                                    </a>
                                </div>
                                <div class="destination-content">
                                    <a href="{{ route('property.listing', ['country_id' =>'1', 'state_id' => '38', 'type' => 'state']) }}">
                                        <h3>Tennessee</h3>
                                        <div class="view___more"><span>View more</span><i class="bi bi-arrow-right"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="slide-item">
                                <div class="box-item-card">
                                    <a href="{{ route('property.listing', ['country_id' =>'1', 'state_id' => '10', 'type' => 'state']) }}">
                                        <div class="desti-image">
                                            <img src="{{ asset('frontend-assets/images/popular-destination/Florida.jpeg') }}" alt="Image">
                                        </div>
                                    </a>
                                </div>
                                <div class="destination-content">
                                    <a href="{{ route('property.listing', ['country_id' =>'1', 'state_id' => '10', 'type' => 'state']) }}">
                                        <h3>Florida</h3>
                                        <div class="view___more"><span>View more</span><i class="bi bi-arrow-right"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2 mb-3">
                    <a href="#" class="listing-card-four__btn hrbo-btn"> View more <span class="icon"><i
                                class="bi bi-arrow-right"></i> </span></a>
                </div>
            </div>
        </div>
        <div class="destination__bottom__img">
            <img src="{{ asset('frontend-assets/images/shape/monjil.webp') }}" alt="img">
        </div>
    </section>
    <section class="py-5">
        <div class="container">
            <div class="section_hrbo___titles">
                <p>Property Type's</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Enjoy the Diverse Experiences</h2>
                <button class="btn btn-danger rounded-pill px-4 py-2">View All →</button>
            </div>

            <!-- CARDS -->
            <div class="experience-wrapper">

                <!-- 1. Adventure -->
                <div class="exp-card">
                    <img src="{{ asset('frontend-assets/images/hawaii-hrbo.jpg') }}">
                    <div class="vertical-title">ADVENTURE</div>
                    <div class="label-top">FAMILY FUN</div>

                    <div class="expanded-details">
                        <div class="icon-box"><i class="bi bi-people"></i></div>
                        <p class="exp-sub-title">TOGETHER</p>
                        <h1 class="exp-main-title">Family</h1>
                        <p class="exp-desc">Create lasting memories with family-friendly adventure activities.</p>

                        <div class="badge-row">
                            <span class="badge-item">👶 Kids</span>
                            <span class="badge-item">🏖 Beach</span>
                            <span class="badge-item">🚌 Tours</span>
                        </div>

                        <p class="exp-price">STARTS FROM <strong>$ 13,600</strong></p>
                        <button class="explore-btn">Explore →</button>
                    </div>
                </div>

                <!-- 2. Honeymoon -->
                <div class="exp-card">
                    <img src="{{ asset('frontend-assets/images/arizona-hrbo.jpg') }}">
                    <div class="vertical-title">HONEYMOON</div>
                    <div class="label-top">SPECIAL</div>

                    <div class="expanded-details">
                        <div class="icon-box"><i class="bi bi-heart"></i></div>
                        <p class="exp-sub-title">ROMANCE</p>
                        <h1 class="exp-main-title">Couple</h1>
                        <p class="exp-desc">The perfect romantic escape with candlelight dinners & sunsets.</p>

                        <div class="badge-row">
                            <span class="badge-item">💖 Romance</span>
                            <span class="badge-item">🌅 Sunset</span>
                            <span class="badge-item">🍽 Dinner</span>
                        </div>

                        <p class="exp-price">STARTS FROM <strong>$ 24,500</strong></p>
                        <button class="explore-btn">Explore →</button>
                    </div>
                </div>

                <!-- 3. Shopping -->
                <div class="exp-card">
                    <img src="{{ asset('frontend-assets/images/package/1.jpg') }}">
                    <div class="vertical-title">SHOPPING</div>
                    <div class="label-top">TRENDING</div>

                    <div class="expanded-details">
                        <div class="icon-box"><i class="bi bi-bag"></i></div>
                        <p class="exp-sub-title">EXPLORE</p>
                        <h1 class="exp-main-title">Shopping</h1>
                        <p class="exp-desc">From malls to street markets — everything in one place.</p>

                        <div class="badge-row">
                            <span class="badge-item">👜 Fashion</span>
                            <span class="badge-item">💄 Beauty</span>
                            <span class="badge-item">🎁 Gifts</span>
                        </div>

                        <p class="exp-price">STARTS FROM <strong>$ 8,500</strong></p>
                        <button class="explore-btn">Explore →</button>
                    </div>
                </div>

                <!-- 4. Nightlife -->
                <div class="exp-card">
                    <img src="{{ asset('frontend-assets/images/package/1.jpg') }}">
                    <div class="vertical-title">NIGHTLIFE</div>
                    <div class="label-top">PARTY</div>

                    <div class="expanded-details">
                        <div class="icon-box"><i class="bi bi-lightning-charge"></i></div>
                        <p class="exp-sub-title">ENERGY</p>
                        <h1 class="exp-main-title">Nightlife</h1>
                        <p class="exp-desc">Enjoy clubs, cocktails, DJs, and unforgettable nights.</p>

                        <div class="badge-row">
                            <span class="badge-item">🎶 Music</span>
                            <span class="badge-item">🍹 Drinks</span>
                            <span class="badge-item">💃 Dance</span>
                        </div>

                        <p class="exp-price">STARTS FROM <strong>$ 9,900</strong></p>
                        <button class="explore-btn">Explore →</button>
                    </div>
                </div>

                <!-- 5. Wellness (NEW CARD) -->
                <div class="exp-card">
                    <img src="{{ asset('frontend-assets/images/package/1.jpg') }}">
                    <div class="vertical-title">WELLNESS</div>
                    <div class="label-top">RELAX</div>

                    <div class="expanded-details">
                        <div class="icon-box"><i class="bi bi-flower2"></i></div>
                        <p class="exp-sub-title">CALM</p>
                        <h1 class="exp-main-title">Wellness</h1>
                        <p class="exp-desc">Spa, massage, detox — rejuvenate your body and mind.</p>

                        <div class="badge-row">
                            <span class="badge-item">💆 Spa</span>
                            <span class="badge-item">🧘 Yoga</span>
                            <span class="badge-item">🔥 Sauna</span>
                        </div>

                        <p class="exp-price">STARTS FROM <strong>$ 11,200</strong></p>
                        <button class="explore-btn">Explore →</button>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Deals On Sale Ends -->
    <div class="instagram-slider">
        <div class="slicks-items">
            <div class="instagram-box">
                <div class="insta-post-thumb"><img src="{{ asset('frontend-assets/images/arizona-hrbo.jpg') }}"
                        alt="instagram"></div>
                <div class="insta-post-content"><a href="https://www.instagram.com/" target="_blank"><i
                            class="bi bi-instagram"></i></a></div>
            </div>
        </div>
        <div class="slicks-items">
            <div class="instagram-box">
                <div class="insta-post-thumb"><img src="{{ asset('frontend-assets/images/package/1.jpg') }}"
                        alt="instagram"></div>
                <div class="insta-post-content"><a href="https://www.instagram.com/" target="_blank"><i
                            class="bi bi-instagram"></i></a></div>
            </div>
        </div>
        <div class="slicks-items">
            <div class="instagram-box">
                <div class="insta-post-thumb"><img src="{{ asset('frontend-assets/images/package/2.jpg') }}"
                        alt="instagram"></div>
                <div class="insta-post-content"><a href="https://www.instagram.com/" target="_blank"><i
                            class="bi bi-instagram"></i></a></div>
            </div>
        </div>
        <div class="slicks-items">
            <div class="instagram-box">
                <div class="insta-post-thumb"><img src="{{ asset('frontend-assets/images/package/3.jpg') }}"
                        alt="instagram"></div>
                <div class="insta-post-content"><a href="https://www.instagram.com/" target="_blank"><i
                            class="bi bi-instagram"></i></a></div>
            </div>
        </div>
        <div class="slicks-items">
            <div class="instagram-box">
                <div class="insta-post-thumb"><img src="{{ asset('frontend-assets/images/arizona-hrbo.jpg') }}"
                        alt="instagram"></div>
                <div class="insta-post-content"><a href="https://www.instagram.com/" target="_blank"><i
                            class="bi bi-instagram"></i></a></div>
            </div>
        </div>
        <div class="slicks-items">
            <div class="instagram-box">
                <div class="insta-post-thumb"><img src="{{ asset('frontend-assets/images/package/1.jpg') }}"
                        alt="instagram"></div>
                <div class="insta-post-content"><a href="https://www.instagram.com/" target="_blank"><i
                            class="bi bi-instagram"></i></a></div>
            </div>
        </div>
        <div class="slicks-items">
            <div class="instagram-box">
                <div class="insta-post-thumb"><img src="{{ asset('frontend-assets/images/package/2.jpg') }}"
                        alt="instagram"></div>
                <div class="insta-post-content"><a href="https://www.instagram.com/" target="_blank"><i
                            class="bi bi-instagram"></i></a></div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script>
        const base_url = "{{ url('/') }}";
        const cards = document.querySelectorAll(".exp-card");
        const isMobile = window.innerWidth <= 768;

        if (!isMobile) {
            cards[0].classList.add("active");

            cards.forEach(card => {
                function activate() {
                    cards.forEach(c => c.classList.remove("active"));
                    card.classList.add("active");
                }

                card.addEventListener("mouseenter", activate);
                card.addEventListener("click", activate);
            });
        } else {
            // On mobile, make all cards active
            cards.forEach(card => card.classList.add("active"));
        }
    </script>
    <script>
        let searchInput = document.getElementById('search_destination');
        let resultBox = document.getElementById('destination_list');
        let typingTimer;

        searchInput.addEventListener('keyup', function(e) {
            clearTimeout(typingTimer);

            let keyword = this.value.trim();

            // Check if input is numeric (property ID)
            if (/^\d+$/.test(keyword)) {
                resultBox.innerHTML = '';
                return;
            }

            if (keyword.length >= 3) {
                typingTimer = setTimeout(() => {
                    getSearchDestination(keyword);
                }, 400);
            } else {
                resultBox.innerHTML = '';
            }
        });

        // Handle Enter key to redirect for numeric property ID
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                let keyword = this.value.trim();

                if (/^\d+$/.test(keyword)) {
                    e.preventDefault();
                    e.stopPropagation();
                    redirectToPropertyDetails(keyword);
                    return false;
                }
            }
        });

        // Prevent form submission on Enter for property ID
        searchInput.closest('form').addEventListener('submit', function(e) {
            let keyword = searchInput.value.trim();

            if (/^\d+$/.test(keyword)) {
                e.preventDefault();
                redirectToPropertyDetails(keyword);
                return false;
            }
        });

        function redirectToPropertyDetails(propertyId) {
            // Check if property exists and redirect
            fetch(`${base_url}/check-property/${propertyId}`)
                .then(res => {
                    return res.json();
                })
                .then(data => {
                    if (data.exists && data.url) {
                        window.location.href = data.url;
                    } else {
                        window.location.href = `${base_url}/404`;
                    }
                })
                .catch(err => {
                    alert('Error checking property. Please try again.');
                });
        }

        function getSearchDestination(keyword) {
            fetch(`${base_url}/search-destination?keyword=${encodeURIComponent(keyword)}`)
                .then(res => res.json())
                .then(data => {
                    resultBox.innerHTML = '';

                    if (!data.length) {
                        resultBox.innerHTML = `<li class="list-group-item">No result found</li>`;
                        return;
                    }

                    data.forEach(item => {
                        resultBox.innerHTML += `
                        <li class="list-group-item list-item"
                            onclick='selectDestination(${JSON.stringify(item)})'>
                            ${item.full_address}
                        </li>`;
                    });
                });
        }

        function selectDestination(item) {

            // Set input text
            searchInput.value = item.full_address;
            resultBox.innerHTML = '';

            // Set hidden inputs safely
            document.getElementById('country_id').value = item.country_id ?? '';
            document.getElementById('city_id').value = item.city_id ?? '';
            document.getElementById('sub_city_id').value = item.sub_city_id ?? '';
            document.getElementById('region_id').value = item.region_id ?? '';
            document.getElementById('search_type').value = item.type ?? '';
            document.getElementById('state_id').value = item.state_id ?? '';
            document.getElementById('search_text').value = item.full_address ?? '';
        }
    </script>
@endsection
