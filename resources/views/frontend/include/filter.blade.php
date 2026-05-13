<style>
    .area-searching .date-fields-row {
        display: flex;
        gap: 10px;
    }
    .area-searching .date-field {
        position: relative;
        flex: 1;
        display: flex;
        align-items: center;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04);
        min-height: 46px;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }
    .area-searching .date-field:focus-within {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
    }
    .area-searching .date-field i {
        position: absolute;
        left: 12px;
        color: #6b7280;
        font-size: 15px;
        pointer-events: none;
    }
    .area-searching .date-field input.date-input {
        width: 100%;
        border: 0;
        background: transparent;
        padding: 8px 30px 8px 36px;
        font-size: 14px;
        color: #111827;
        cursor: pointer;
        box-shadow: none;
        border-radius: 8px;
    }
    .area-searching .date-field input.date-input:focus {
        outline: none;
        box-shadow: none;
    }
    .area-searching .date-field .date-clear-btn {
        position: absolute;
        right: 6px;
        top: 50%;
        transform: translateY(-50%);
        background: transparent;
        border: 0;
        font-size: 18px;
        line-height: 1;
        color: #9ca3af;
        cursor: pointer;
        padding: 4px 6px;
        display: none;
        transition: color 0.15s ease;
    }
    .area-searching .date-field .date-clear-btn:hover { color: #ef4444; }
    .area-searching .date-field.has-value .date-clear-btn { display: block; }
    /* Litepicker tweaks */
    .litepicker .container__months {
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        border-radius: 10px;
    }
</style>
<section class="area-searching">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 margin__area">
                <form class="form-searching-inner" action="{{ route('property.listing') }}" method="GET">
                    <input type="hidden" name="country_id" id="country_id">
                    <input type="hidden" name="state_id" id="state_id">
                    <input type="hidden" name="city_id" id="city_id">
                    <input type="hidden" name="sub_city_id" id="sub_city_id">
                    <input type="hidden" name="region_id" id="region_id">
                    <input type="hidden" name="type" id="search_type">
                    <div class="row">
                        <div class="col-md-3 mt-2">
                            <div class="form-group">
                                <div class="check-position mb-3 position-relative">
                                    <input type="text" id="search_destination" class="form-control form-control2" placeholder="Search Property Id or Location" value="{{ old('search_text', $search_text ?? '') }}" autocomplete="off">
                                    <ul id="destination_list" class="list-group position-absolute w-100"
                                        style="z-index:1000;"></ul>

                                    <span><i class="bi bi-geo-alt-fill"></i></span>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <div class="date-fields-row">
                                <div class="date-field {{ request('checkin') ? 'has-value' : '' }}" id="checkInField">
                                    <i class="bi bi-calendar-event"></i>
                                    <input type="text" id="checkIn" name="checkin" class="date-input"
                                           placeholder="Check-in" autocomplete="off" readonly
                                           value="{{ request('checkin') }}">
                                    <button type="button" class="date-clear-btn" data-clear="checkIn" title="Clear">&times;</button>
                                </div>
                                <div class="date-field {{ request('checkout') ? 'has-value' : '' }}" id="checkOutField">
                                    <i class="bi bi-calendar-check"></i>
                                    <input type="text" id="checkOut" name="checkout" class="date-input"
                                           placeholder="Check-out" autocomplete="off" readonly
                                           value="{{ request('checkout') }}">
                                    <button type="button" class="date-clear-btn" data-clear="checkOut" title="Clear">&times;</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 mt-2">
                            <button type="submit"><i class="fa fa-search"></i> Search</button>
                            <input type='button' name='type' id='bt1' value='More Filters'onClick="setVisibility('sub3');" ;>
                        </div>
                        <div class="col-md-3 mt-2">
                            <div class="form-group">
                                <div class='input-group input-group2'>
                                    <select name="beds" class="form-control">
                                        <option value="">Select Beds</option>
                                        <option selected="" value="0">Studio</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                    </select>
                                    <i class="bi bi-chevron-down mt-2"></i>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-3 mt-2">
                            <div class="form-group">
                                <div class='input-group input-group2'>
                                    <select name="sleeps" class="form-control">
                                        <option value="">Select Sleeps</option>
                                        @for ($i = 1; $i <= 25; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <i class="bi bi-chevron-down mt-2"></i>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mt-2">
                            <div class="form-group">
                                <div class='input-group input-group2'>
                                    <select name="property_type" class="form-control">
                                        <option value="">Property Type</option>
                                        @foreach ($propertyTypes as $propertyType)
                                            <option value="{{ $propertyType->id }}">{{ $propertyType->name }}</option>
                                        @endforeach
                                    </select>
                                    <i class="bi bi-chevron-down mt-2"></i>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mt-2">
                            <div class="form-group">
                                <div class='input-group input-group2'>
                                    <select name="sortby" class="form-control">
                                        <option value="">Property Sort By</option>
                                        <option value="updated">Latest</option>
                                        <option value="bedsDesc">Beds Desc</option>
                                        <option value="bedsAsc">Beds Asc</option>
                                        <option value="rating">Rating</option>
                                    </select>
                                    <i class="bi bi-chevron-down mt-2"></i>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div style="display:none;" id="sub3">
            <div class="moreoption">
                @foreach ($amenities as $aminity)
                    <h4>{{ $aminity->name }}</h4>
                    <ul>
                        @foreach ($aminity->sub_amenities as $subAmenities)
                            <li><span><input type="checkbox"
                                        value="{{ $subAmenities->id }}"></span>{{ ucfirst($subAmenities->name) }}</li>
                        @endforeach
                    </ul>
                @endforeach
            </div>
        </div>
    </div>
</section>
