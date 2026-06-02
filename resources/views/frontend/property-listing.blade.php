
@extends('frontend.layouts.master')
@push('div_start')
<div class="innerheader">
@endpush
@push('div_end')
</div>
@endpush
@section('css1')
<style>
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
@include('frontend.include.filter')
<section class="breadcrumb inner-breadcrumb-area">
    <div class="container-xxl">
        <ul>
            <li><a href="{{ route('frontend.index') }}">Home</a></li>
            @if($search_text && !$country_name)
            <li>Search: "{{ $search_text }}"</li>
            @endif
            @if($country_name)
            <li>
                <a href="{{ route('frontend.destination') }}">
                    {{ strlen($country_name->name)<=3?strtoupper($country_name->name):ucfirst($country_name->name) }}
                </a>
            </li>
            @endif
            @if($state_name)
                @if(request()->input('type')=="state")
                <li>
                    {{ ucfirst($state_name->name) }} Vacation Rentals
                </li>
                @else
                <li>
                    <a href="{{ route('property.listing',['country_id'=>$state_name->country_id,'state_id'=>$state_name->id,'type'=>'state']) }}">
                        {{ strlen($state_name->name)<=3?strtoupper($state_name->name):ucfirst($state_name->name) }}
                    </a>
                </li>
                @endif
            @endif
            @if(request()->input('type')=='Region' )
            <li>
                {{ ucfirst($region_name->name) }} Vacation Rentals
            </li>
            @else
                @if(!empty($region_name))
                <li>
                    <a href="{{ route('property.listing',['country_id'=>$region_name->country_id,'state_id'=>$region_name->state_id,'region_id'=>$region_name->id,'type'=>'Region']) }}">
                        {{ ucfirst($region_name->name) }}
                    </a>
                </li>
                @endif
            @endif
            @if(request()->input('type')=='City')
                <li>
                    {{ ucfirst($city_name->name) }} Vacation Rentals
                </li>
            @else
                @if(!empty($city_name))
                <li>
                    <a href="{{ route('property.listing',['country_id'=>$city_name->country_id,'state_id'=>$city_name->state_id,'region_id'=>$city_name->region_id,'city_id'=>$city_name->id,'type'=>'City']) }}">
                        {{ ucfirst($city_name->name) }}
                    </a>
                </li>
                @endif
            @endif
            @if(request()->input('type')=='SubCity' && $sub_city_name)
                <li>
                    {{ ucfirst($sub_city_name->name) }} Vacation Rentals
                </li>
            @endif
        </ul>
    </div>
</section>
<section class="gray-bg p-0">
    <div class="container">
        <div class="row">
            <div class="col-md-8 mt-3">
                <div class="area-heading">
                    @if(request()->input('type')=="state" && $state_name)
                    <h1>{{ ucfirst($state_name->name) }} Vacation Rentals By Owner</h1>
                    @elseif(request()->input('type')=='Region' && $region_name)
                    <h1>{{ ucfirst($region_name->name) }} Vacation Rentals By Owner</h1>
                    @elseif(request()->input('type')=='City' && $city_name)
                    <h1>{{ ucfirst($city_name->name) }} Vacation Rentals By Owner</h1>
                    @elseif(request()->input('type')=='SubCity' && $sub_city_name)
                    <h1>{{ ucfirst($sub_city_name->name) }} Vacation Rentals By Owner</h1>
                    @elseif($search_text)
                    <h1>Search Results for "{{ $search_text }}"</h1>
                    @endif
                </div>
            </div>
            <div class="col-md-4 mt-3">
                <div class="showmore-cities">
                    <input type='button' name='type' id='cities' value='Show Location' onClick="showCities('showcities');";>
                </div>
            </div>
        </div>
        <br>
        <div style="display:none;" id="showcities">
            @if($type=='Region')
                @if($regions->count()>0)
                <ul class="more-city-list">
                    @foreach ($regions as $region)
                    <li><a href="{{ route('property.listing',['country_id'=>$region->country_id,'state_id'=>$region->state_id,'region_id'=>$region->id,'type'=>$type]) }}"> {{ ucfirst($region->name) }}  Vacation Rentals By Owner</a></li>
                    @endforeach
                </ul>
                @endif
            @endif
            @if($type=='City')
                @if($cites->count()>0)
                <ul class="more-city-list">
                    @foreach ($cites as $city)
                    <li><a href="{{ route('property.listing',['country_id'=>$city->country_id,'state_id'=>$city->state_id,'region_id'=>$city->region_id,'city_id'=>$city->id,'type'=>$type]) }}"> {{ ucfirst($city->name) }}  Vacation Rentals By Owner</a></li>
                    @endforeach
                </ul>
                @endif
            @endif

            @if(request()->input('type')=='SubCity')
                @if($subCities->count() >0)
                    <ul class="more-city-list">
                        @foreach ($subCities as $Subcity)
                            <li><a href="{{ route('property.listing',['country_id'=>$Subcity->country_id,'state_id'=>$Subcity->state_id,'region_id'=>$Subcity->region_id,'city_id'=>$Subcity->city_id,'subcity_id'=>$Subcity->id,'type'=>$type]) }}"> {{ ucfirst($Subcity->name) }}  Vacation Rentals By Owner</a></li>
                        @endforeach
                    </ul>
                @endif
            @endif

        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    @foreach ($propertyListings as $key=> $propertyList)
                        <div class="col-sm-4 col-md-4 mt-3 mb-2">
                            <div class="listing-card-two wow fadeInUp animated" data-wow-duration="1500ms" data-wow-delay="100ms" style="visibility: visible; animation-duration: 1500ms; animation-delay: 100ms; animation-name: fadeInUp;">
                                <div class="listing-card-two__image">
                                    <img src="{{env('IMAGE_URL').'/upload/property_image/main_image/'.$propertyList->property_image}}" alt="{{ $propertyList->property_name }}">
                                    <a href="{{ route('property.details',['id'=>$propertyList->id]) }}" class="listing-card-two__overlay"></a>
                                    <div class="listing-card-two__btns">
                                        <a href="#" class="listing-card-two__popup card__popup">
                                            <span class="bi bi-heart"></span>
                                        </a>
                                        <a class="video-popup" href="#"><span class="bi bi-image"></span></a>
                                    </div>
                                    <ul class="listing-card-inner__meta list-unstyled">
                                        <li><a href="#"><span><i class="bi bi-building-fill-check"></i> {{$propertyList->propertyType->name??"" }}</span></a></li>
                                        <li>
                                            <a href="#" tabindex="0"> <span class="listing-card-four__meta__icon">{{ $propertyList->bedrooms }} Bathrooms</a>
                                        </li>
                                        <li>
                                            <a href="#" tabindex="0"> <span class="listing-card-four__meta__icon"> </span>{{ $propertyList->bathrooms }} Bedrooms</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="listing-card-two__content">

                                    <h3 class="listing-card-two__title"><a href="{{ route('property.details',['id'=>$propertyList->id]) }}">{{ $propertyList->property_name }}</a></h3>
                                    <div class="listing-card-two__content__inner">
                                        <ul class="listing-card-two__meta list-unstyled">
                                            <li>
                                                <a href="{{ route('property.details',['id'=>$propertyList->id]) }}"> <span class="listing-card-two__meta__icon"> <i class="bi bi-geo-alt-fill"></i> </span>@if($propertyList->city !=null ) {{ ucfirst($propertyList->city->name) }}, @endif {{ ucfirst($propertyList->state->name??"") }}</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('property.details',['id'=>$propertyList->id]) }}"> <span class="listing-card-two__meta__icon"> <i class="bi bi-calendar-week"></i> </span>{{ $propertyList->sleeps }} Sleeps</a>
                                            </li>
                                        </ul>
                                        <div class="listing-card-two__price">
                                            <h5 class="listing-card-two__price__number">${{ $propertyList->avg_night }}<span>/Per {{ $propertyList->rate_per_unit}}</span></h5>
                                            <i class="bi bi-heart"></i>
                                        </div>
                                    </div>
                                    <div class="list-two-btns mt-3">
                                        <a href="{{ route('property.details',['id'=>$propertyList->id]) }}" class="listing-card-four__btn hrbo-btn"> View Details <span class="icon"><i class="bi bi-arrow-right"></i> </span></a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mb-3">
                    {!! $propertyListings->withQueryString()->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@push('js')
<script src="{{ asset('frontend-assets/js/sidebar-fixed.js') }}"></script>
<script>
    function showCities(id) {
        if(document.getElementById('cities').value=='Hide Location'){
            document.getElementById('cities').value = 'Show Location';
            document.getElementById(id).style.display = 'none';
        }
        else{
            document.getElementById('cities').value = 'Hide Location';
            document.getElementById(id).style.display = 'inline';
        }
    }

    function setVisibility(id) {
        if(document.getElementById('bt1').value=='Hide'){
            document.getElementById('bt1').value = 'More Filters';
            document.getElementById(id).style.display = 'none';
        }
        else{
            document.getElementById('bt1').value = 'Hide';
            document.getElementById(id).style.display = 'inline';
        }
    }

    // autocomplete(document.getElementById('destinatio_input'));

    function resetForm() {
        // $('#applyFilter')[0].reset();

        $("select[name=beds]").val('');
        $("select[name=sleeps]").val('');
        $("select[name=property_type]").val('');
        $("#applyFilter")[0].submit();
    }
</script>
 <script>
        const base_url = "{{ url('/') }}";
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
            console.log('Checking property ID:', propertyId);

            // Check if property exists and redirect
            fetch(`${base_url}/check-property/${propertyId}`)
                .then(res => {
                    console.log('Response status:', res.status);
                    return res.json();
                })
                .then(data => {
                    console.log('Response data:', data);

                    if (data.exists && data.url) {
                        console.log('Redirecting to:', data.url);
                        window.location.href = data.url;
                    } else {
                        console.log('Property not found, redirecting to 404');
                        window.location.href = `${base_url}/404`;
                    }
                })
                .catch(err => {
                    console.error('Error checking property:', err);
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
        }
    </script>


@endpush
