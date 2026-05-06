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
                        <div class="small-title">Amenities</div>
                        <div class="add-listing-section">
                            <form id="amenitiesProperties">
                                <div class="with-forms">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="newameties">
                                                <input type="hidden" name="property_id" id="" value="{{ request()->id }}">
                                                @if (!empty($properties))
                                                    <input type="hidden" name="type" value="edit">
                                                @endif
                                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                    @if (!empty($properties))
                                                        @php
                                                            $subAmenitiesId = [];
                                                            $childAmenitiesId = [];
                                                            $amenities =$properties->property_amenites->toArray();
                                                            foreach($amenities as $aminity):
                                                                if($aminity['child_amenites_id'] !=null):
                                                                    $childAmenitiesId[] = $aminity['child_amenites_id'];
                                                                else:
                                                                    $subAmenitiesId[] = $aminity['sub_amenites_id'];
                                                                endif;
                                                            endforeach;
                                                        @endphp
                                                    @endif
                                                    @foreach ($ammienites as $key=> $amenity)
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" id="heading_{{ $key+1 }}" role="tab">
                                                                <h4 class="panel-title">
                                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_{{ $key+1 }}" aria-expanded="false" aria-controls="collapse_{{ $key+1 }}">{{ $amenity->name }}
                                                                        <i class="pull-right fa fa-plus"></i>
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <div class="panel-collapse collapse show" id="collapse_{{ $key+1 }}" role="tabpanel" aria-labelledby="heading_{{ $key+1 }}" >
                                                                <div class="panel-body">
                                                                    <div class="amenitiesBox">
                                                                        @if(!empty($amenity->sub_amenities))
                                                                            @foreach ($amenity->sub_amenities as $subAmenities)
                                                                                @if(count($subAmenities->child_amienites)<=0)
                                                                                    <li> <input type="checkbox"class="amenites" data-level="subAmenities" value="{{ $subAmenities->id }}" name="subaminities[]" @isset($subAmenitiesId)
                                                                                            @if (in_array($subAmenities->id,$subAmenitiesId))
                                                                                                checked
                                                                                            @endif
                                                                                        @endisset> {{ ucfirst($subAmenities->name) }}
                                                                                        
                                                                                        <div class="description_{{ $subAmenities->id }} amentiestext">
                                                                                            @isset($subAmenitiesId)
                                                                                            @if (in_array($subAmenities->id,$subAmenitiesId))
                                                                                                @if (App\Http\Helper\Helper::checkDescriptionAmenites($subAmenities->id,"sub_amenities"))
                                                                                                <textarea  placeholder="Describe yourself here..." class="form-control h-150px" rows="2" name="description[subAmenities][]"> </textarea>
                                                                                                @endif
                                                                                            @endif
                                                                                            @endisset
                                                                                        </div>
                                                                                    </li>
                                                                                @else
                                                                                <div class="amenities-title">{{ ucfirst($subAmenities->name) }}</div>
                                                                                    <ul>
                                                                                        @foreach ($subAmenities->child_amienites as $childAmenities)
                                                                                            <li> <input type="checkbox" name="childAmenities[]" class="amenites" data-level="chlidrenAmenites" value="{{ $childAmenities->id }}"   @isset($childAmenitiesId)
                                                                                            @if (in_array($childAmenities->id,$childAmenitiesId))
                                                                                                checked
                                                                                            @endif
                                                                                        @endisset> {{ ucfirst($childAmenities->name) }}</li>
                                                                                            <div class="description_per_{{ $childAmenities->id }} amentiestext">
                                                                                                @isset($childAmenitiesId)
                                                                                                    @if (in_array($childAmenities->id,$childAmenitiesId))
                                                                                                        @if (App\Http\Helper\Helper::checkDescriptionAmenites($childAmenities->id,"child_amenities"))
                                                                                                        <textarea  placeholder="Describe yourself here..." class="form-control h-150px" rows="2" name="description[chlidrenAmenites][]"> </textarea>
                                                                                                        @endif
                                                                                                    @endif
                                                                                                 @endisset
                                                                                            </div>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                    <br>
                                                                                @endif
                                                                
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>    
                                        </div>
                                        <div class="col-md-12">
                                            <button class="button preview" type="submit">Save &amp; Continue <i class="fa fa-arrow-circle-right"></i><button>
                                        </div>
                                    </div>
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
<script src="{{ asset('frontend-assets/js/ownerJs/property/amenities.js') }}"></script>    
<script>
    $(" input.amenites[type=checkbox] ").on("click", function () {
    showloader();
    let className;
    if ($(this).attr("data-level") == "subAmenities") {
        className = "description_" + $(this).val();
    } else {
        className = "description_per_" + $(this).val();
    }
    // alert($(this).attr('data-level'));
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: site_url + "/admin/property/check-aminites-description",
        type: "POST",
        data: { id: $(this).val(), type: $(this).attr("data-level") },
        cache: false,
        success: (res) => {
            hideLoader();
            if (res.data.description == 1) {
                let description = `<textarea  placeholder="Describe yourself here..." class="form-control h-150px" rows="2" name="description[${$(
                    this
                ).attr("data-level")}][]"> </textarea>`;
                if (this.checked) {
                    $("." + className).html(description);
                } else {
                    $("." + className).html("");
                }
            }
        },
    });
});
</script>
@endpush