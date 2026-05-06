@extends('frontend.layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend-assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend-assets/css/chosen.min.css') }}">
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
                        <div class="small-title">Description</div>
                        <div class="add-listing-section">
                            <form id="propertyDescription">
                                <!-- Row -->
                                <div class="with-forms">
                                    <div class="row">
                                        <!-- Type -->
                                        <input type="hidden" name="property_id" value="{{ $properties->id??"" }}">
                                        <div class="col-md-6">
                                            <label for="property_name">Property Name</label>
                                            <input type="text" placeholder="Property Name" name="property_name" id="property_name" class="form-control" value="{{ $properties->property_name??"" }}">
                                            <span class="property_name-error text-danger"></span>
                                        </div>                       
                                        <div class="col-md-6">
                                            <label for="property_suitablity">Property Suitablity</label>
                                            <select name="property_suitablity[]" id="property_suitablity" class="form-control chosen-select" multiple data-placeholder="Suitablity">
                                                {{-- <option value="">Select Suitablity</option> --}}
                                                @php
                                                    if(!empty($properties)):
                                                        $suitablityId = gettype($properties->property_suitablity_id) !='array'?json_decode($properties->property_suitablity_id,true):$properties->property_suitablity_id;
                                                    endif;
                                                 @endphp
                                                @foreach ($properties_suitablities as $suitablity)
                                                    <option value="{{ $suitablity->id }}" @if(!empty($properties)) @selected(in_array($suitablity->id,$suitablityId)) @endif>{{ $suitablity->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="property_suitablity-error text-danger"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="property_photo">Property Photo</label>
                                            @if(!empty($properties))
                                            <input type="hidden" name="property_old_image" value="{{$properties->property_image}}">
                                            @endif
                                            <input type="file" name="property_photo" id="property_photo" class="form-control">
                                            <span class="property_photo-error text-danger"></span>
                                        </div> 
                                        <div class="col-md-6">
                                            <label for="square_feet">Square Feet</label>
                                            <input type="text" name="square_feet" id="square_feet" class="form-control" placeholder="Square Feet" onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')" value="{{ $properties->square_feet??"" }}">
                                            <span class="square_feet-error text-danger"></span>
                                        </div> 
                                        <div class="col-md-6">
                                            <label for="property_type">Property Type</label>
                                            <select name="property_type" id="property_type" class="form-control">
                                                <option value="">Select Property Type</option>
                                                @foreach ($properties_type as $propertyType)
                                                    <option value="{{ $propertyType->id }}" @if (!empty($properties))
                                                        @selected($properties->property_types_id== $propertyType->id)
                                                    @endif>{{ $propertyType->name }}</option>    
                                                @endforeach
                                            </select>
                                            <span class="property_type-error text-danger"></span>
                                        </div>                     
                                        <div class="col-md-6">
                                            <label for="bedrooms">Bedrooms</label>
                                            <select name="bedrooms" id="bedrooms" class="form-control">
                                                <option value="">Select Bedrooms</option>
                                                @for($i=1;$i<=20;$i++)
                                                    @if($i ==20)
                                                        <option value="{{ $i }}+"  @if(!empty($property)) @selected($i."+"==$properties->bedrooms) @endif>{{ $i }}+ Bedrooms</option>
                                                    @else
                                                        <option value="{{ $i }}"  @if(!empty($properties)) @selected($i==$properties->bedrooms) @endif>{{ $i }} Bedrooms</option>
                                                    @endif>
                                                @endfor
                                            </select>
                                            <span class="bedrooms-error text-danger"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="sleeps">Sleeps</label>
                                            <input type="text" name="sleeps" class="form-control" placeholder="Sleeps" id="sleeps" onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')" value="{{ $properties->sleeps??"" }}">
                                            <span class="sleeps-error text-danger"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="avg-night">Avg. Night</label>
                                            <div class="input-group">
                                                <input type="text" name="avg_night" class="form-control" placeholder="Avg Night" aria-label="Avg Night"  id="avg-night" onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')" value="{{ $properties->avg_night??"" }}">
                                                <select name="rate_per_unit" class="input-group-append">
                                                    <option value="">Select</option>
                                                    <option value="Nightly"@if(!empty($properties)) @selected($properties->rate_per_unit=='Nightly') @endif>Nightly Rate</option>
                                                    <option value="Weekly" @if(!empty($properties)) @selected($properties->rate_per_unit=='Weekly') @endif>Weekly Rate</option>
                                                    <option value="Monthly" @if(!empty($properties)) @selected($properties->rate_per_unit=='Monthly') @endif>Monthly Rate</option>
                                                </select>
                                            </div>
                                            <span class="avg_night-error text-danger"></span>
                                            <span class="rate_per_unit-error text-danger" style="
                                            margin-left: 37px;"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="baths">Baths</label>
                                            <select name="baths" class="form-control" placeholder="Baths" id="baths">
                                                <option value="">Select Baths </option>
                                                <option value="1"@if(!empty($properties)) @selected($properties->bathrooms=='1') @endif>1 Bathroom</option>
                                                <option value="1.5" @if(!empty($properties)) @selected($properties->bathrooms=='1.5') @endif>1.5 Bathrooms</option>
                                                <option value="2" @if(!empty($properties)) @selected($properties->bathrooms=='2') @endif>2 Bathrooms</option>
                                                <option value="2.5"@if(!empty($properties)) @selected($properties->bathrooms=='2.5') @endif>2.5 Bathrooms</option>
                                                <option value="3"@if(!empty($properties)) @selected($properties->bathrooms=='3') @endif>3 Bathrooms</option>
                                                <option value="3.5" @if(!empty($properties)) @selected($properties->bathrooms=='3.5') @endif>3.5 Bathrooms</option>
                                                <option value="4" @if(!empty($properties)) @selected($properties->bathrooms=='4') @endif>4 Bathrooms</option>
                                                <option value="4.5" @if(!empty($properties)) @selected($properties->bathrooms=='4.5') @endif>4.5 Bathrooms</option>
                                                <option value="5" @if(!empty($properties)) @selected($properties->bathrooms=='5') @endif>5 Bathrooms</option>
                                                <option value="5.5" @if(!empty($properties)) @selected($properties->bathrooms=='5.5') @endif>5.5 Bathrooms</option>
                                                <option value="6"@if(!empty($properties)) @selected($properties->bathrooms=='6') @endif>6 Bathrooms</option>
                                                <option value="6.5" @if(!empty($properties)) @selected($properties->bathrooms=='6.5') @endif>6.5 Bathrooms</option>
                                                <option value="7" @if(!empty($properties)) @selected($properties->bathrooms=='7') @endif>7 Bathrooms</option>
                                                <option value="7.5" @if(!empty($properties)) @selected($properties->bathrooms=='7.5') @endif>7.5 Bathrooms</option>
                                                <option value="8" @if(!empty($properties)) @selected($properties->bathrooms=='8') @endif>8 Bathrooms</option>
                                                <option value="8.5" @if(!empty($properties)) @selected($properties->bathrooms=='8.5') @endif>8.5 Bathrooms</option>
                                                <option value="9" @if(!empty($properties)) @selected($properties->bathrooms=='9') @endif>9 Bathrooms</option>
                                                <option value="9.5" @if(!empty($properties)) @selected($properties->bathrooms=='9.5') @endif>9.5 Bathrooms</option>
                                                <option value="10" @if(!empty($properties)) @selected($properties->bathrooms=='10') @endif>10 Bathrooms</option>
                                                <option value="10.5"@if(!empty($properties)) @selected($properties->bathrooms=='10.5') @endif>10.5 Bathrooms</option>
                                                <option value="11" @if(!empty($properties)) @selected($properties->bathrooms=='11') @endif>11 Bathrooms</option>
                                                <option value="11.5"@if(!empty($properties)) @selected($properties->bathrooms=='11.5') @endif>11.5 Bathrooms</option>
                                                <option value="12" @if(!empty($properties)) @selected($properties->bathrooms=='12') @endif>12 Bathrooms</option>
                                                <option value="12.5"@if(!empty($properties)) @selected($properties->bathrooms=='12.5') @endif>12.5 Bathrooms</option>
                                                <option value="13" @if(!empty($properties)) @selected($properties->bathrooms=='13') @endif>13 Bathrooms</option>
                                                <option value="13.5"@if(!empty($properties)) @selected($properties->bathrooms=='13.5') @endif>13.5 Bathrooms</option>
                                                <option value="14" @if(!empty($properties)) @selected($properties->bathrooms=='14') @endif>14 Bathrooms</option>
                                                <option value="14.5"@if(!empty($properties)) @selected($properties->bathrooms=='14.5') @endif>14.5 Bathrooms</option>
                                                <option value="15" @if(!empty($properties)) @selected($properties->bathrooms=='15') @endif>15 Bathrooms</option>
                                                <option value="15.5"@if(!empty($properties)) @selected($properties->bathrooms=='15.5') @endif>15.5 Bathrooms</option>
                                                <option value="16"@if(!empty($properties)) @selected($properties->bathrooms=='16') @endif>16 Bathrooms</option>
                                                <option value="17" @if(!empty($properties)) @selected($properties->bathrooms=='17') @endif>17 Bathrooms</option>
                                                <option value="18"@if(!empty($properties)) @selected($properties->bathrooms=='18') @endif>18 Bathrooms</option>
                                                <option value="19" @if(!empty($properties)) @selected($properties->bathrooms=='19') @endif>19 Bathrooms</option>
                                                <option value="20"@if(!empty($properties)) @selected($properties->bathrooms=='29') @endif>20 Bathrooms</option>
                                                <option value="Studio" @if(!empty($properties)) @selected($properties->bathrooms=='Studio') @endif>Studio </option>
                                            </select>
                                            <span class="baths-error text-danger"></span>

                                        </div>
                                        <div class="col-md-12">
                                            <label for="description">Description</label>
                                            <textarea class="form-control h-150px" rows="6" id="description" name="description">{{ $properties->description??"" }}</textarea>
                                            <span class="description-error text-danger"></span>

                                        </div>
                                        <div class="col-md-6">
                                            <label for="country">Country</label>
                                            <select class="form-control" name="country_name" id="country_name" onchange="getStates(this.value)">
										        <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                <option value="{{ $country->id }}" @if(!empty($properties)) @selected($properties->country_id== $country->id) @endif>{{ ucfirst($country->name) }}</option>
                                                @endforeach
									        </select>
                                            <span class="country_name-error text-danger"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="state_name">State</label>
                                            <select name="state_name" id="state_name" class="form-control" onchange="getRegion(this.value)">
                                                <option value="">Select State</option>
                                                @if(!empty($states))
                                                    @foreach($states as $state)
                                                        <option value="{{ $state->id }}" @if(!empty($properties)) @selected($properties->state_id== $state->id) @endif>{{ ucfirst($state->name) }}</option>
                                                    @endforeach
                                                @endif;
                                            </select>
                                            <span class="state_name-error text-danger"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="region_name" class="form-label">Region Name</label>
                                            <select name="region_name" id="region_name" class="form-control" onchange="getCity(this.value)">
                                                <option value="">Select Region</option>
                                                @if(!empty($regions))
                                                    @foreach ($regions as $region)
                                                    <option value="{{ $region->id }}" @if(!empty($properties)) @selected($properties->region_id==  $region->id) @endif>{{ ucfirst( $region->name) }}</option>
                                                    @endforeach
                                                @endif
                                            </select> 
                                            <span class="region_name-error text-danger"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="city_name">City</label>
                                            <select class="form-control" name="city_name" id="city_name" onchange="getSubCity(this.value)">
                                                <option value="">Select City</option>
                                                @if(!empty($cities))
                                                    @foreach ($cities as $city)
                                                        <option value="{{ $city->id }}" @if(!empty($properties)) @selected($properties->city_id==  $city->id) @endif>{{ ucfirst($city->name) }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="city_name-error text-danger"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="sub_city_name">Sub City</label>
                                            <select class="form-control" name="sub_city" id="sub_city_name">
                                                <option value="">Select Sub city</option>
                                                @if (!empty($subCities))
                                                    @foreach ($subCities as $subCity)
                                                        <option value="{{ $subCity->id }}" @if(!empty($properties)) @selected($properties->sub_city_id== $subCity->id) @endif>{{ ucfirst($subCity->name) }}</option>
                                                    @endforeach
                                                    
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="extrnal_website_link">External Link(Video , Virtual Tour)</label>
                                            <input type="text" class="form-control" id="extrnal_link" placeholder="External Website Link" name="external_website_link" value="{{ $properties->extrnal_link??"" }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="personal_website_link">Personal Website Link</label>
                                            <input type="text" name="personal_website_link" id="personal_website_link" placeholder="Personal Website Link" value="" class="form-control" value="{{ $properties->personal_website_link??"" }}">
                                        </div>
                                        <div class="col-md-12">
                                            <button class="button preview" type="submit">Save &amp; Continue <i class="fa fa-arrow-circle-right"></i><button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Row / End -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('admin-auth-assets/js/common.js') }}"></script>
    <script src="{{ asset('frontend-assets/js/ownerJs/property/property_information.js') }}"></script>
    <script src="{{ asset('frontend-assets/js/chosen.jquery.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/12.3.1/classic/ckeditor.js"></script>
    <script>
        $(document).ready(function(){
            $(".chosen-select").chosen({
                no_results_text: "Oops, nothing found!"
            })
            ClassicEditor.create(document.querySelector("#description"))
            .then((editor) => {
                descriptionEditor = editor;
                editor.keystrokes.set('space', (key, stop) => {
                    editor.execute('input', {
                        text: ' '
                    });
                    stop();
                });
            })
            .catch((error) => {
                console.error(error);
            });
        })
        $(document).ready(function(){
            $(".chosen-select").chosen({
                no_results_text: "Oops, nothing found!"
            })
        })
    </script>
@endpush