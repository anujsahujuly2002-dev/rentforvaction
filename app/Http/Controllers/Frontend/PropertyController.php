<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Helper\Helper;
use App\Models\Aminities;
use App\Models\City;
use App\Models\Country;
use App\Models\Property;
use App\Models\PropertyBooking;
use App\Models\PropertyTypes;
use App\Models\Region;
use App\Models\State;
use App\Models\SubCity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\PropertyInquiry;
use App\Mail\PropertyInquiryConfirmation;
use App\Models\Inquiry;

class PropertyController extends Controller
{
    public function index(Request $request){
        $regions=[];
        $region_name='';
        $cites=[];
        $subCities=[];
        $city_name='';
        $sub_city_name='';
        $search_text = '';
        $type = '';

        $amenities = Aminities::where('status','1')->get();
        $propertyTypes = PropertyTypes::get();
        $country_name = Country::where('id',$request->input('country_id'))->first();
        $state_name = State::where('id',$request->input('state_id'))->first();

        if ($request->filled('search_text')) {
            $search_text = $request->input('search_text');
        }

        // Free-text search: no location selected from dropdown
        if (!$request->filled('state_id') && $request->filled('search_text')) {
            $keyword = $request->input('search_text');
            $propertyListings = Property::where('property_approved', '1')
                ->where('property_name', 'like', '%' . $keyword . '%');
        } else {
            $propertyListings = Property::where('state_id', $request->input('state_id'))->where('property_approved','1');
        }

        if($request->input('type')=='state' || $request->input('type')=='State'):
            $regions = Region::where('state_id',$request->input('state_id'))->get();
            $type="Region";
        endif;
        if($request->input('type')=='Region' || $request->input('type')=='region'):
            $region_name = Region::where('id',$request->input('region_id'))->first();
            $cites = City::where('region_id',$request->input('region_id'))->get();
            $type="City";
            $propertyListings = $propertyListings->where('region_id',$request->input('region_id'));
        endif;
        if($request->input('type')=='City' ||  $request->input('type')=='city'):
            $region_name = Region::where('id',$request->input('region_id'))->first();
            $city_name = City::where('id',$request->input('city_id'))->first();
            $type = "SubCity";
            $subCities = SubCity::where('city_id',$request->input('city_id'))->get();
             $propertyListings = $propertyListings->where('city_id',$request->input('city_id'));
        endif;
        if($request->input('type')=='SubCity'  ||  $request->input('type')=='sub_city' ):
            $region_name = Region::where('id',$request->input('region_id'))->first();
            $city_name = City::where('id',$request->input('city_id'))->first();
            $type = "SubCity";
            $subCities = SubCity::where('city_id',$request->input('city_id'))->get();
            $propertyListings = $propertyListings->where('sub_city_id',$request->input('subcity_id'));
            $sub_city_name = SubCity::where('id',$request->input('subcity_id'))->first();
        endif;
        if ($request->type === 'city') {
            $region_name = Region::find($request->region_id);
            $city_name   = City::find($request->city_id);

            $subCities = SubCity::where('city_id', $request->city_id)->get();

            $propertyListings = $propertyListings->where('city_id', $request->city_id);

            $type = "SubCity";
        }

        if ($request->type === 'sub_city') {

            $region_name   = Region::find($request->region_id);
            $city_name     = City::find($request->city_id);
            $sub_city_name = SubCity::find($request->sub_city_id);

            $subCities = SubCity::where('city_id', $request->city_id)->get();

            $propertyListings = $propertyListings
                ->where('city_id', $request->city_id)
                ->where('sub_city_id', $request->sub_city_id);

            $type = "SubCity";
        }

        $propertyListings = $propertyListings->orderByRaw('CASE WHEN user_id = 1 THEN 1 ELSE 0 END')->orderBy('id','ASC')->paginate(15);

        $propertyDataInMap = [];
        foreach($propertyListings as $property):
            $propertyDataInMap[]=[
                'id'=> $property->id,
                'name'=>$property->property_name,
                'location'=>[
                    'lat'=> $property->latitude,
                    'lon'=> $property->longitude,
                ],
            ];
        endforeach;

        return view('frontend.property-listing',compact('propertyListings','amenities','propertyTypes','regions','type','country_name','state_name','region_name','cites','subCities','city_name','sub_city_name','propertyDataInMap','search_text'));
    }

    public function propertyDetails (Request $request){
        $propertyDetail = Property::where('id',$request->input('id'))->first();

        // Build booked dates map from property bookings
        $bookedDates = [];
        if ($propertyDetail) {
            $bookings = PropertyBooking::where('property_id', $propertyDetail->id)->get();
            foreach ($bookings as $booking) {
                $start = Carbon::parse($booking->start_date);
                $end = Carbon::parse($booking->end_date);
                $checkinKey = $start->format('Y-m-d');
                $checkoutKey = $end->format('Y-m-d');

                if ($start->eq($end)) {
                    // Same day booking: mark as booked (full)
                    $bookedDates[$checkinKey] = 'booked';
                } else {
                    // Check-in day: half block (right side)
                    // If already marked as checkout from another booking, it becomes full booked
                    if (isset($bookedDates[$checkinKey]) && $bookedDates[$checkinKey] === 'checkout') {
                        $bookedDates[$checkinKey] = 'checkout-checkin';
                    } elseif (!isset($bookedDates[$checkinKey]) || $bookedDates[$checkinKey] === 'available') {
                        $bookedDates[$checkinKey] = 'checkin';
                    }

                    // All days between check-in and check-out are fully booked
                    $cursor = $start->copy()->addDay();
                    while ($cursor->lt($end)) {
                        $bookedDates[$cursor->format('Y-m-d')] = 'booked';
                        $cursor->addDay();
                    }

                    // Check-out day: half block (left side)
                    // If already marked as checkin from another booking, it becomes full booked
                    if (isset($bookedDates[$checkoutKey]) && $bookedDates[$checkoutKey] === 'checkin') {
                        $bookedDates[$checkoutKey] = 'checkout-checkin';
                    } elseif (!isset($bookedDates[$checkoutKey]) || $bookedDates[$checkoutKey] === 'available') {
                        $bookedDates[$checkoutKey] = 'checkout';
                    }
                }
            }
        }

        return view('frontend.property-details',compact('propertyDetail','bookedDates'));
    }

    public function checkProperty($id) {
        try {
            // Validate that ID is numeric
            if (!is_numeric($id)) {
                return response()->json([
                    'exists' => false,
                    'url' => null,
                    'error' => 'Invalid property ID format'
                ], 400);
            }

            $property = Property::where('id', $id)
                ->where('property_approved', '1')
                ->first();

            if ($property) {
                return response()->json([
                    'exists' => true,
                    'url' => route('property.details', ['id' => ($property->id)])
                ]);
            }

            return response()->json([
                'exists' => false,
                'url' => null,
                'message' => 'Property not found or not approved'
            ]);
        } catch (\Exception $e) {
            Log::error('Error checking property: ' . $e->getMessage());

            return response()->json([
                'exists' => false,
                'url' => null,
                'error' => 'Server error'
            ], 500);
        }
    }

    public function submitInquiry(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'first_name'  => 'required|string|max:100',
            'last_name'   => 'required|string|max:100',
            'phone'       => 'required|string|max:20',
            'email'       => 'required|email|max:150',
            'checkin'     => 'nullable|date',
            'checkout'    => 'nullable|date|after_or_equal:checkin',
            'adults'      => 'nullable|integer|min:0|max:20',
            'children'    => 'nullable|integer|min:0|max:20',
            'message'     => 'nullable|string|max:2000',
            'captcha'     => 'required|captcha',
        ], [
            'captcha.required' => 'Please enter the captcha.',
            'captcha.captcha'  => 'Invalid captcha. Please try again.',
        ]);

        try {
            $property = Property::with('user')->findOrFail($request->property_id);

            $inquiryData = [
                'property_id'   => $property->id,
                'property_name' => $property->property_name,
                'first_name'    => $request->first_name,
                'last_name'     => $request->last_name,
                'phone'         => $request->phone,
                'email'         => $request->email,
                'checkin'       => $request->checkin,
                'checkout'      => $request->checkout,
                'adults'        => $request->adults ?? 0,
                'children'      => $request->children ?? 0,
                'message'       => $request->message,
            ];

            $ownerEmail = $property->user->email ?? null;

            // Send email to property owner
            if ($ownerEmail) {
                Mail::to($ownerEmail)->send(new PropertyInquiry($inquiryData));
                Mail::to('varunchanana1788@gmail.com')->send(new PropertyInquiry($inquiryData));
            }

            // Send confirmation email to traveller
            Mail::to($request->email)->send(new PropertyInquiryConfirmation($inquiryData));

            Inquiry::create(array_merge($inquiryData, ['source' => 'frontend']));

            return response()->json(['status' => 'success', 'message' => 'Your inquiry has been sent successfully!']);
        } catch (\Exception $e) {
            Log::error('Property inquiry email failed: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Failed to send inquiry. Please try again later.'], 500);
        }
    }

}
