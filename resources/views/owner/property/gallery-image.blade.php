@extends('frontend.layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend-assets/css/dashboard.css') }}">
    <style>
    .image_container {
        height: 120px;
        width: 150px;
        border-radius: 6px;
        overflow: hidden;
        margin: 10px;
        display: inline-block;
        vertical-align: top;
        position: relative;
    }
    .image_container img {
        height:100%;
        width: auto;
        object-fit: cover;
    }
    .image_container span {
        top: 6px;
        right: 6px;
        color: red;
        font-size: 16px;
        font-weight: normal;
        cursor: pointer;
        position: absolute;
        background: #fff;
        padding: 5px 8px;
        display: block;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        line-height: 20px;
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
            <div class="das-title">Property Information</div>
            @include('owner.layouts.owner-navbar')
            <div class="property-mainsection">
                <div class="row">
                    @include('owner.property.left-sidebar')
                    <div class="col-md-10">
                        <div class="small-title">Property Gallery Image</div>
                        <div class="add-listing-section">
                            <form id="galleryImage">
                                <input type="hidden" value="{{ request()->id }}" name="property_id">
                                @if (!empty($properties))
                                    <input type="hidden" name="type" value="edit">
                                @endif
                                <div class="with-forms">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label for="property-gallery-image" class="form-label">Property Gallery Image</label>
                                            <input type="file" class="form-control" id="property-gallery-image" placeholder="Name" name="property-gallery-image" accept="image/png, image/gif, image/jpeg , image/jpg" multiple accept="" onchange="image_select()"  />
                                        </div>
                                        <div class="col-md-12">
                                            <div class="card-body d-flex flex-wrap justify-content-start" id="container">
                                                @if (!empty($properties))
                                                    @foreach ($properties->galleryImage as $galleryImage)
                                                        <div class="image_container" id="gallery_image_{{ $galleryImage->id }}">
                                                            <img src="{{ env('IMAGE_URL') . '/upload/property_image/gallery_image/'.$properties->id.'/'.$galleryImage->image_name }}" alt="Image" srcset="">
                                                            <span class="position-absolute" onclick="deleteGalleryImage({{ $galleryImage->id }})"><i class="fa fa-trash-o" aria-hidden="true"></i></span>
                                                        </div>
                                                    @endforeach
                                                @endif
                                        </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="button preview">Save &amp; Update
                                                <i class="fa fa-arrow-circle-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- Row / End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('admin-auth-assets/js/common.js') }}"></script>
    <script src="{{ asset('admin-auth-assets/js/swal.js') }}"></script>
    <script src="{{ asset('frontend-assets/js/ownerJs/property/gallery_image.js') }}"></script>

@endpush
