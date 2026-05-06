@extends('frontend.layouts.master')
@section('css1')
<style>
    .navigation {
        position: relative;
        z-index: 99;
        width: 100%;
        /* background: var(--theme-color); */
        color: #000;
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
                    <h1>Recommended For You</h1>
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
            @if($recommendedProperties->count() > 0)
                @foreach($recommendedProperties as $recommendation)
                    <div class="col-sm-4 col-md-4 mt-3 mb-2">
                        <div class="listing-card-two wow fadeInUp animated" data-wow-duration="1500ms" data-wow-delay="100ms" style="visibility: visible; animation-duration: 1500ms; animation-delay: 100ms; animation-name: fadeInUp;">
                            <div class="listing-card-two__image">
                                @if(!empty($recommendation->property->property_image))
                                    <img src="{{ env('IMAGE_URL') . '/upload/property_image/main_image/' . $recommendation->property->property_image }}" alt="{{ $recommendation->property->property_name }}">
                                @else
                                    <img src="{{ asset('frontend-assets/images/list/1.webp') }}" alt="Property Image">
                                @endif
                                <a href="{{ route('property.details', ['id' => $recommendation->property->id]) }}" class="listing-card-two__overlay"></a>
                                <div class="listing-card-two__btns">
                                    <a href="#" class="listing-card-two__popup card__popup">
                                        <span class="bi bi-heart"></span>
                                    </a>
                                    <a class="video-popup" href="#"><span class="bi bi-image"></span></a>
                                </div>
                                <ul class="listing-card-inner__meta list-unstyled">
                                    <li><a href="#"><span><i class="bi bi-building-fill-check"></i> {{ $recommendation->property->propertyType->name ?? 'Property' }}</span></a></li>
                                    <li>
                                        <a href="#" tabindex="0"> <span class="listing-card-four__meta__icon">{{ $recommendation->property->bathrooms ?? 0 }} Bathrooms</span></a>
                                    </li>
                                    <li>
                                        <a href="#" tabindex="0"> <span class="listing-card-four__meta__icon">{{ $recommendation->property->bedrooms ?? 0 }} Bedrooms</span></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="listing-card-two__content">
                                <h3 class="listing-card-two__title"><a href="{{ route('property.details', ['id' => $recommendation->property->id]) }}">{{ App\Http\Helper\Helper::limit_text($recommendation->property->property_name, 5) }}</a></h3>
                                <div class="listing-card-two__content__inner">
                                    <ul class="listing-card-two__meta list-unstyled">
                                        <li>
                                            <a href="#"> <span class="listing-card-two__meta__icon"> <i class="bi bi-geo-alt-fill"></i> </span>
                                                @php
                                                    $locationParts = array_filter([
                                                        $recommendation->property->country->name ?? null,
                                                        $recommendation->property->state->name ?? null,
                                                        $recommendation->property->region->name ?? null,
                                                        $recommendation->property->city->name ?? null,
                                                    ]);
                                                @endphp
                                                {{ implode(', ', $locationParts) }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#"> <span class="listing-card-two__meta__icon"> <i class="bi bi-calendar-week"></i> </span>{{ $recommendation->property->sleeps ?? 0 }} Sleeps</a>
                                        </li>
                                    </ul>
                                    <div class="listing-card-two__price">
                                        <h5 class="listing-card-two__price__number">${{ $recommendation->property->avg_night ?? 0 }}<span>/Per Nightly</span></h5>
                                        <i class="bi bi-heart"></i>
                                    </div>
                                </div>
                                <div class="list-two-btns mt-3">
                                    <a href="{{ route('property.details', ['id' => $recommendation->property->id]) }}" class="listing-card-four__btn hrbo-btn"> View Details <span class="icon"><i class="bi bi-arrow-right"></i> </span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-sm-12 text-center">
                    <p class="mt-5 mb-5">No recommended properties available at the moment.</p>
                </div>
            @endif
        </div>
    </div>
</section>


@endsection
@push('js')

@endpush
