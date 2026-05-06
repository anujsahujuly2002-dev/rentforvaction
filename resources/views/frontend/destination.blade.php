@extends('frontend.layouts.master')
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
    <section class="area-searching destination-search">
        <div class="container">

            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="inner__desti__titles">
                        <h1>World Vacation Rentals</h1>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <form class="inner-form-searchings" method="GET" action="{{ route('property.listing') }}">
                        <input type="hidden" name="country_id" id="country_id">
                        <input type="hidden" name="state_id" id="state_id">
                        <input type="hidden" name="city_id" id="city_id">
                        <input type="hidden" name="sub_city_id" id="sub_city_id">
                        <input type="hidden" name="region_id" id="region_id">
                        <input type="hidden" name="type" id="search_type">
                        <input type="hidden" name="search_text" id="search_text">
                        <div class="row">
                            <div class="col-md-4 mt-3">
                                <div class="form-group">
                                    <div class="check-position mb-3 position-relative">
                                        <input type="text" id="search_destination" class="form-control" placeholder="Search Property Id or Location" autocomplete="off">
                                        <ul id="destination_list" class="list-group position-absolute w-100" style="z-index:1000;"></ul>
                                        <span><i class="bi bi-geo-alt-fill"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 mt-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class='input-group input-group4 date' >
                                                <input type='date' class="form-control" value="Check In"
                                                    title="Check In" />
                                                <span class="tooltip">Check In <sup>*</sup></span>
                                                <i class="flaticon-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-icon">
                                            <div class='input-group input-group4 date' >
                                                <input type='date' class="form-control" value="Check Out"
                                                    title="Check Out" />
                                                <span class="tooltip">Check Out <sup>*</sup></span>
                                                <i class="flaticon-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mt-3">
                                <button type="submit"><i class="fa fa-search"></i> Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section class="gray-bg p-0">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="accordion panel-default" id="accordionDestination">
                        @foreach ($countries as $country)
                            <div class="accordion-item">
                                <div class="accordion-header">
                                    <div class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <div class="panel-heading">
                                            <a href="javascript:void()">
                                                <strong>{{ strlen($country->name) <= 3 ? strtoupper($country->name) : ucfirst($country->name) }}  Vacation Rentals</strong></a>
                                        </div>
                                    </div>
                                </div>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordionDestination">
                                    <div class="accordion-body">
                                        <ul>
                                            @foreach ($country->state as $state)
                                                <li><a
                                                        href="{{ route('property.listing', ['country_id' => $state->country_id, 'state_id' => $state->id, 'type' => 'state']) }}"><span
                                                            class="icons"><i class="bi bi-geo-alt-fill"></i></span><span
                                                            class="locations">{{ ucfirst($state->name) }}</span></a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <!-- <div class="accordion-item">
                                                                                                                <h2 class="accordion-header">
                                                                                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                                                                                        Accordion Item #2
                                                                                                                    </button>
                                                                                                                </h2>
                                                                                                                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                                                                                                    <div class="accordion-body">
                                                                                                                        <strong>This is the second item’s accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It’s also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div> -->

                    </div>
                </div>
                <!-- <div class="col-sm-12 col-md-12 col-lg-12">
                                                                                                        @foreach ($countries as $country)
    <div class="panel-default">
                                                                                                            <div class="panel-heading">
                                                                                                                <a href="javascript:void()">
                                                                                                                    <strong>{{ strlen($country->name) <= 3 ? strtoupper($country->name) : ucfirst($country->name) }} Vacation Rentals</strong></a>
                                                                                                            </div>
                                                                                                            <ul>
                                                                                                                @foreach ($country->state as $state)
    <li><a href="{{ route('property.listing', ['country_id' => $state->country_id, 'state_id' => $state->id, 'type' => 'state']) }}"><span class="icons"><i class="bi bi-geo-alt-fill"></i></span><span class="locations">{{ ucfirst($state->name) }}</span></a></li>
    @endforeach
                                                                                                            </ul>
                                                                                                        </div>
    @endforeach
                                                                                                    </div> -->
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        const base_url = "{{ url('/') }}";

        function setVisibility(id) {
            if (document.getElementById('bt1').value == 'Hide') {
                document.getElementById('bt1').value = 'More Filters';
                document.getElementById(id).style.display = 'none';
            } else {
                document.getElementById('bt1').value = 'Hide';
                document.getElementById(id).style.display = 'inline';
            }
        }
    </script>
    <script>
        function setVisibility(id) {
            if (document.getElementById('cities').value == 'Hide Cities') {
                document.getElementById('cities').value = 'Show Cities';
                document.getElementById(id).style.display = 'none';
            } else {
                document.getElementById('cities').value = 'Hide Cities';
                document.getElementById(id).style.display = 'inline';
            }
        }
    </script>
    <script>
        let searchInput = document.getElementById('search_destination');
        let resultBox = document.getElementById('destination_list');
        let typingTimer;

        searchInput.addEventListener('keyup', function() {
            clearTimeout(typingTimer);

            let keyword = this.value.trim();

            if (keyword.length >= 3) {
                typingTimer = setTimeout(() => {
                    getSearchDestination(keyword);
                }, 400);
            } else {
                resultBox.innerHTML = '';
            }
        });

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
@endpush
