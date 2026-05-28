<div class="col-md-2">
    <div class="left-sidebar">
        <ul>
            <li><a href="@if(request()->type=="edit") {{ route('owner.property.create',['id'=>request()->id,'type'=>"edit"]) }} @else javascript:void(0) @endif" @if (request()->route()->getName()=='owner.property.create')
                class="active"
            @endif>Description</a></li>
            <li><a href="@if(request()->type=="edit") {{ route('owner.property.amenities',['id'=>request()->id,'type'=>"edit"]) }} @else javascript:void(0) @endif"  @if (request()->route()->getName()=='owner.property.amenities')
                class="active"
            @endif>Amenities</a></li>
            <li><a href="@if(request()->type=="edit") {{ route('owner.property.location',['id'=>request()->id,'type'=>"edit"]) }} @else javascript:void(0) @endif" @if (request()->route()->getName()=='owner.property.location')
                class="active"
            @endif>Location</a></li>
            <li><a href="@if(request()->type=="edit") {{ route('owner.property.rental.rates',['id'=>request()->id,'type'=>"edit"]) }} @else javascript:void(0) @endif" @if (request()->route()->getName()=='owner.property.rental.rates')
                class="active"
            @endif>Rental Rates</a></li>

            <li><a href="@if(request()->type=="edit") {{ route('owner.property.gallery.image',['id'=>request()->id,'type'=>"edit"]) }} @else javascript:void(0) @endif" @if (request()->route()->getName()=='owner.property.gallery.image')
                class="active"
            @endif>Photos</a></li>
            <li><a href="@if(request()->type=="edit") {{ route('owner.property.rental.policies',['id'=>request()->id,'type'=>"edit"]) }} @else javascript:void(0) @endif"  @if (request()->route()->getName()=='owner.property.rental.policies')
                class="active"
            @endif>Rental Policies</a></li>
            <li><a href="@if(request()->type=="edit") {{ route('owner.property.calender',['id'=>request()->id,'type'=>"edit"]) }} @else javascript:void(0) @endif" @if (request()->route()->getName()=='owner.property.calender')
                class="active"
            @endif>Calender</a></li>
            <li><a href="@if(request()->type=="edit") {{ route('owner.property.reviews',['id'=>request()->id,'type'=>"edit"]) }} @else javascript:void(0) @endif" @if (request()->route()->getName()=='owner.property.reviews')
                class="active"
            @endif>Reviews</a></li>
            <li><a href="@if(request()->type=="edit") {{ route('owner.property.enquiry',['id'=>request()->id,'type'=>"edit"]) }} @else javascript:void(0) @endif" @if (request()->route()->getName()=='owner.property.enquiry') class="active" @endif>Enquiry</a></li>
        </ul>
    </div>
</div>
