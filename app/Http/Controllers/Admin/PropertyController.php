<?php

namespace App\Http\Controllers\Admin;

use Hash;
use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Region;
use App\Models\Country;
use App\Models\SubCity;
use App\Models\Currency;
use App\Models\Property;
use App\Models\Aminities;
use App\Http\Helper\Helper;
use App\Models\PropertyRate;
use App\Models\SubAmenities;
use Illuminate\Http\Request;
use App\Models\PropertyTypes;
use App\Models\PropertyBooking;
use App\Models\PropertyReviews;
use App\Models\UserInformation;
use App\Models\FeaturedProperty;
use App\Models\Recommendation;
use App\Models\PropertyAmenites;
use App\Models\PropertySuitablity;
use App\Models\ThirdLevelAmenities;
use App\Http\Controllers\Controller;
use App\Models\PropertyGalleryImage;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Property\RatesRequest;
use App\Http\Requests\Property\RentalRatesRequest;
use App\Http\Requests\Property\PropertyReviewsRequest;
use Spatie\Permission\Exceptions\UnauthorizedException;
use App\Http\Requests\Property\PropertyInformationRequest;

class PropertyController extends Controller
{
    public function index(Request $request){
        if(!Auth::user()->can('property-list')):
            throw UnauthorizedException::forPermissions(['property-list']);
        endif;

        if($request->ajax()):
            $property = Property::with('recommendation')->orderBy('id','DESC');
            return DataTables::of($property)
            ->addIndexColumn()
            ->editColumn('property_name',function($row){
                return Helper::limit_text($row->property_name,3);
            })
            ->addColumn('featured_property',function($row){
                $status=1;
                $attaribute="";
                if($row->featuredProperty !=null):
                    $status = 0;
                    $attaribute="checked";
                endif;
                $featuredBtn = '<label class="switch"><input type="checkbox" onclick="featured_property('.$row->id.','.$status.')" '.$attaribute.'><span class="slider round"></span> </label>';
                return $featuredBtn;
            })
            ->addColumn('action', function($row){
                $user = Auth::user();
                $editBtn='';
                $deleteBtn='';
                if($user->can('property-edit')):
                    $editBtn = '<a class="dropdown-item" href="'.route('admin.property.create',['id'=>encrypt($row->id)]).'"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                endif;
                if($user->can('property-delete')):
                    $deleteBtn = ' <a class="dropdown-item" href="javascript:void(0);" onclick="deleteProperty('.$row->id.')"><i class="bx bx-trash me-1"></i> Delete</a>';
                endif;
                $actionBtn = '<div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
				'.$editBtn.$deleteBtn.'
                </div>
              </div>';
                return $actionBtn;
            })
            ->editColumn('property_main_photos',function($row) {
                if (!empty($row->property_image)) {
                    return '<img src="'.env('IMAGE_URL').'/upload/property_image/main_image/'.$row->property_image.'" class=" rounded-circle mr-3" height="50" width="50">';
                } else {
                    return '<img src="'.env('APP_URL').'/public/admin-auth-assets/img/no-image.png" class=" rounded-circle mr-3" height="50" width="50">';
                }
            })
            ->addColumn('created_date',function($row){
                return date('d F Y',strtotime($row->created_at));
            })
            ->addColumn("property_approved",function($row){
                $status=1;
                $attaribute="";
                if($row->property_approved ==1):
                    $status = 0;
                    $attaribute="checked";
                endif;
                $propertyApprovedBtn = '<label class="switch"><input type="checkbox" onclick="approvedProperty('.$row->id.','.$status.')" '.$attaribute.' ><span class="slider round"></span> </label>';
                return $propertyApprovedBtn;
            })
            ->editColumn('subscription_date',function($row){
                return $row->subscription_date !=null?date('d F Y',strtotime($row->subscription_date)):"NA";
            })
            ->addColumn('renewal_date',function ($row) {
                return $row->subscription_date !=null?date('d F Y',strtotime('+1 year' ,strtotime($row->subscription_date))):"NA";
            })
            ->addColumn('is_recommended',function($row){
                $status=1;
                $attaribute="";
                if($row->recommendation != null):
                    $status = 0;
                    $attaribute="checked";
                endif;
                $recommendBtn = '<label class="switch"><input type="checkbox" onclick="addRecommendation('.$row->id.','.$status.')" '.$attaribute.'><span class="slider round"></span> </label>';
                return $recommendBtn;
            })
            ->rawColumns(['action','created_date','property_main_photos','featured_property','property_approved','is_recommended'])
            ->filterColumn('DT_RowIndex', function($query, $keyword) {
                // Don't filter on DT_RowIndex as it's a virtual column
                return;
            })
            ->orderColumn('DT_RowIndex', function ($query, $order) {
                // Don't order by DT_RowIndex, use id instead
                return $query->orderBy('id', $order);
            })
            ->make(true);
        endif;
        return view('admin.property.index');
    }

    public function create($id=null) {
        if(!Auth::user()->can('property-create')):
            throw UnauthorizedException::forPermissions(['property-create']);
        endif;
        $property="";
        $states='';
        $regions="";
        $cities = "";
        $subCities="";
        $countries = Country::latest()->get();
        $ammienites = Aminities::where('status','1')->get();
        $properties_type =PropertyTypes::latest()->get();
        $properties_suitablities = PropertySuitablity::latest()->get();
        $currencies = Currency::latest()->get();
        if(!is_null($id)):
            $property = Property::where('id',decrypt($id))->first();
            $states = State::where('country_id',$property->country_id)->get();
            $regions = Region::where('state_id',$property->state_id)->get();
            $cities = City::where('region_id',$property->region_id)->get();
            $subCities=SubCity::where('city_id',$property->city_id)->get();
        endif;
        return view('admin.property.create',compact('countries','ammienites','properties_type','properties_suitablities','currencies','property','states','regions','cities','subCities'));
    }
    public function getPropertyRates (Request $request) {
        if(!Auth::user()->can('property-rates-list')):
            throw UnauthorizedException::forPermissions(['property-rates-list']);
        endif;
        if($request->ajax()):
            $property_rates = PropertyRate::where('property_id',$request->property_id)->latest();
            return DataTables::of($property_rates)
            ->addIndexColumn()
            ->addColumn('action',function($row){
                $editBtn = '<a class="dropdown-item" href="javascript:void(0)" onclick="editRentalRates('.$row->id.')"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                $deleteBtn = ' <a class="dropdown-item" href="javascript:void(0);" onclick="deleteProperty('.$row->id.')"><i class="bx bx-trash me-1"></i> Delete</a>';
                $actionBtn = '<div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
				'.$editBtn.$deleteBtn.'
                </div>
              </div>';
                return $actionBtn;
            })

            ->rawColumns(['action'])
            ->make(true);
        endif;
    }

    public function checkAminitesDescription(Request $request){
        $data=[];
        if($request->input('type')==="chlidrenAmenites"):
            $amenitiesDescription = ThirdLevelAmenities::where('id',$request->input('id'))->first();
            if($amenitiesDescription->description==="1"):
                $data=[
                    'description'=>1
                ];
            endif;
        else:
            $amenitiesDescription = SubAmenities::where('id',$request->input('id'))->first();
            if($amenitiesDescription->description==="1"):
                $data=[
                    'description'=>1
                ];
            endif;
        endif;

        return response()->json([
            'status'=>true,
            'data'=>$data
        ]);
    }

    // Property Information Store method
    public function propertyInformation(PropertyInformationRequest $request) {
        if($request->hasfile('property_main_image')):
            $path = storage_path('public/upload/property_image/main_image/');
            if(file_exists($path.$request->input('property_old_image'))):
                unlink($path.$request->input('property_old_image'));
            endif;
            $image = $request->file('property_main_image');
            $ext = "webp";
            $convertImage = \Image::make($image->getRealPath())->resize(650, 960)->encode($ext,100);
            $originalImageName = uniqid().'.'.$ext;
            \Storage::put('public/upload/property_image/main_image/'.$originalImageName, $convertImage);
        endif;
        if($request->input('property_id') !=null):
            $property = Property::where('id',$request->input('property_id'))->update([
                'added_by'=>Auth::user()->id,
                'property_name'=>$request->input('property_name'),
                'property_suitablity_id'=>json_encode(explode(',',$request->input('property_suitablity'))),
                'property_image'=>$originalImageName??$request->input("property_old_image"),
                'square_feet'=>$request->input('square_feet'),
                'property_types_id'=>$request->input('property_type'),
                'bedrooms'=>$request->input('bedrooms'),
                'sleeps'=>$request->input('sleeps'),
                'avg_night'=>$request->input('avg_night'),
                'rate_per_unit'=>$request->input('rate_per_unit'),
                'bathrooms'=>$request->input('baths'),
                'description'=>$request->input('description'),
                'country_id'=>$request->input('country_name'),
                'state_id'=>$request->input('state_name'),
                'region_id'=>$request->input('region_name'),
                'city_id'=>$request->input('city_name'),
                'sub_city_id'=>$request->input('sub_city'),
                'extrnal_link'=>$request->input('external_website_link'),
                'personal_website_link'=>$request->input('personal_website_link')
               ]);
               if($property):
                return response()->json([
                    'status'=>'1',
                    'property_id'=>$property->id??$request->input('property_id')
                ]);
               endif;
        else:
           $property = Property::create([
            'user_id'=>Auth::user()->id,
            'added_by'=>Auth::user()->id,
            'property_name'=>$request->input('property_name'),
            'property_suitablity_id'=>json_encode(explode(',',$request->input('property_suitablity'))),
            'property_image'=>$originalImageName,
            'square_feet'=>$request->input('square_feet'),
            'property_types_id'=>$request->input('property_type'),
            'bedrooms'=>$request->input('bedrooms'),
            'sleeps'=>$request->input('sleeps'),
            'avg_night'=>$request->input('avg_night'),
            'rate_per_unit'=>$request->input('rate_per_unit'),
            'bathrooms'=>$request->input('baths'),
            'description'=>$request->input('description'),
            'country_id'=>$request->input('country_name'),
            'state_id'=>$request->input('state_name'),
            'region_id'=>$request->input('region_name'),
            'city_id'=>$request->input('city_name'),
            'sub_city_id'=>$request->input('sub_city'),
            'extrnal_link'=>$request->input('external_website_link'),
            'personal_website_link'=>$request->input('personal_website_link')
           ]);
           if($property):
            return response()->json([
                'status'=>'1',
                'property_id'=>$property->id
            ]);
           endif;
        endif;
    }


    public function amenitesStore(Request $request){
        foreach($request->input('amenites') as $amenity):
           if($amenity['type']=='subAmenities'):
                $amenites = SubAmenities::findOrFail($amenity['id']);
                $checkPropertyAmenites = PropertyAmenites::where(['property_id'=>$amenity['property_id'],'sub_amenites_id'=>$amenites->id])->first();
                if(!is_null($checkPropertyAmenites)):
                    $checkPropertyAmenites->delete();
                endif;
                $propertyAmenites = PropertyAmenites::create([
                    'property_id'=>$amenity['property_id'],
                    'amenites_id'=>$amenites->amenities_id,
                    'sub_amenites_id'=>$amenites->id,
                    'description'=>$amenity['description']
                ]);
           else:
            $amenites = ThirdLevelAmenities::findOrFail($amenity['id']);
            $checkPropertyChildAmenites = PropertyAmenites::where(['property_id'=>$amenity['property_id'],'child_amenites_id'=>$amenites->id])->first();
            if(!is_null($checkPropertyChildAmenites)):
                $checkPropertyChildAmenites->delete();
            endif;

            $propertyAmenites = PropertyAmenites::create([
                'property_id'=>$amenity['property_id'],
                'amenites_id'=>$amenites->amenities_id,
                'sub_amenites_id'=>$amenites->sub_amenities_id,
                'child_amenites_id'=>$amenites->id,
                'description'=>$amenity['description']
            ]);
           endif;
        endforeach;
        if($propertyAmenites):
            return response()->json([
                'status'=>'1'
            ]);
        endif;
    }

    public function locationStore (Request $request){
        $property = Property::where('id',$request->input('property_id'))->update([
            'address'=>$request->input('address'),
            'iframe_link'=>$request->input('iframe_link'),
            'latitude'=>$request->input('latitude')??Helper::getCoordinates($request->input('address'))['latitude'],
            'longitude'=>$request->input('longiutde')??Helper::getCoordinates($request->input('address'))['longitude'],
        ]);

        if($property){
            return response()->json([
                'status'=>'1'
            ]);
        }
    }

    public function ratesStore(RatesRequest $request) {
        $propertyRates = PropertyRate::create([
            "property_id"=>$request->input('property_id'),
            "session_name"=>$request->input('session_name'),
            "start_date"=>$request->input('start_date'),
            "end_date"=>$request->input('end_date'),
            "nightly_rate"=>$request->input('nightly_rate'),
            "weekly_rate"=>$request->input('weekly_rate'),
            "weekend_rate"=>$request->input('weekend_rate'),
            "monthly_rate"=>$request->input('monthly_rate'),
            "minimum_stay"=>$request->input('minimum_stay'),

        ]);

        if($propertyRates):
            return response()->json([
                'status'=>"1",
                "msg"=>"Rate Added Succesfully"
            ]);
        else:
            return response()->json([
                'status'=>"1",
                "msg"=>"Rate not added Please Try again",
            ]);
        endif;

    }

    public function rentalRatesStore(RentalRatesRequest $request) {
        $propertyRentalRates = Property::where('id',$request->input('property_id'))->update([
            'admin_fees'=>$request->input('admin_fees'),
            'cleaning_fees'=>$request->input('cleaning_fees'),
            'refundable_damage_deposite'=>$request->input('refundable_damage_deposite'),
            'danage_waiver'=>$request->input('danage_waiver'),
            'pet_fee'=>$request->input('pet_fee'),
            'pet_rate_per_unit'=>$request->input('pet_rate_per_unit'),
            'extra_person_fee'=>$request->input('extra_person_fee'),
            'after_guest'=>$request->input('after_guest'),
            'poolheating_fee'=>$request->input('poolheating_fee'),
            'pool_heating_fees_perday'=>$request->input('pool_heating_fees_perday'),
            'check_in'=>$request->input('check_in'),
            'check_out'=>$request->input('check_out'),
            'tax_rates'=>$request->input('tax_rates'),
            'change_over'=>$request->input('change_over'),
            'currency_id'=>$request->input('all_rates_are_in'),
            'rates_notes'=>$request->input('rates_notes'),
            "pet_allowed"=>$request->input('pet_allowed'),
            "smoking_allowed"=>$request->input('smoked_allowed'),
        ]);
        if($propertyRentalRates):
            return response()->json([
                'status'=>"1",

            ]);
        else:
            return response()->json([
                'status'=>"1",
            ]);
        endif;
    }

    public function galleryImageStore(Request $request){
        $propertyGalleryImage ='';
        if($request->input('totalFiles')>0):
            for($x = 0; $x < $request->input('totalFiles'); $x++):
                if($request->hasFile("files".$x)):
                    $image = $request->file('files'.$x);
                    $ext = "webp";
                    $convertImage = \Image::make($image->getRealPath())->resize(1000, 720)->encode($ext,100);
                    $originalImageName = uniqid().'.'.$ext;
                    \Storage::put('public/upload/property_image/gallery_image/'.$request->input("property_id").'/'.$originalImageName, $convertImage);
                    $propertyGalleryImage = PropertyGalleryImage::create([
                        "property_id"=>$request->input("property_id"),
                        "image_name"=>$originalImageName
                    ]);
                endif;
            endfor;
        endif;
        return response()->json([
            'status'=>'1'
        ]);
    }

    public function rentalPolicesStore(Request $request){
        $file_name='';
        $cancel_rental_file_name="";
        if($request->hasFile('upload_rental_policies')):
            $file = $request->file('upload_rental_policies');
            $ext = $file->getClientOriginalExtension();
            $file_name = uniqid().'.'.$ext;
            $file->move(storage_path('app/public/upload/rental_policies/'),$file_name);
        endif;
        if($request->hasFile('upload_cancel_policies')):
            $file = $request->file('upload_cancel_policies');
            $ext = $file->getClientOriginalExtension();
            $cancel_rental_file_name = uniqid().'.'.$ext;
            $file->move(storage_path('app/public/upload/rental_policies/'),$file_name);
        endif;
        $propertyRentalPolicies = Property::where('id',$request->input('property_id'))->update([
            'rental_policies'=>$request->input('rental_policies'),
            'cancel_polices'=>$request->input('cancel_polices'),
            'upload_rental_policies'=>$file_name,
            'upload_cancel_policies'=>$cancel_rental_file_name,
        ]);
        if($propertyRentalPolicies):
            return response()->json([
                'status'=>'1',
            ]);
        endif;
    }

    public function calenderSyncronization(Request $request) {
        try{
            $ical_response = file_get_contents($request->input('ical_link'));
            // Normalize line endings: iCal uses \r\n, strip \r to avoid parsing issues
            $ical_response = str_replace("\r", "", $ical_response);
            $icsDates = array ();
            $icsData = explode ( "BEGIN:", $ical_response );
            foreach ( $icsData as $key => $value ) {
                $icsDatesMeta [$key] = explode ( "\n", $value );
            }
            foreach ( $icsDatesMeta as $key => $value ) {
                foreach ( $value as $subKey => $subValue ) {
                    $icsDates = Helper::getICSDates ( $key, $subKey, trim($subValue), $icsDates );
                }
            }
            unset($icsDates[0]);
            unset($icsDates[1]);
            $property_booking ="";
            $insertedCount = 0;
            foreach ($icsDates as $key => $icsDate) :
                // Support both DTSTART;VALUE=DATE and DTSTART formats
                $startRaw = $icsDate['DTSTART;VALUE=DATE'] ?? ($icsDate['DTSTART'] ?? null);
                $endRaw = $icsDate['DTEND;VALUE=DATE'] ?? ($icsDate['DTEND'] ?? null);
                if (!$startRaw || !$endRaw) continue;

                $dateTimeStamp = array_key_exists('DTSTAMP',$icsDate) ? date("Y-m-d H:i:s", strtotime(trim($icsDate['DTSTAMP']))) : null;
                $startDate = date("Y-m-d", strtotime(trim($startRaw)));
                $endDate = date("Y-m-d", strtotime(trim($endRaw)));
                $events = isset($icsDate['SUMMARY']) ? trim($icsDate['SUMMARY']) : 'Blocked';

                if ($startDate === '1970-01-01' || $endDate === '1970-01-01') continue;

                $check_booking_date = PropertyBooking::where([
                    'property_id' => $request->input('property_id'),
                    'start_date' => $startDate,
                    'end_date' => $endDate
                ])->first();

                if(is_null($check_booking_date)):
                    $property_booking = PropertyBooking::create([
                        "property_id" => $request->input('property_id'),
                        "start_date" => $startDate,
                        "end_date" => $endDate,
                        "events" => $events,
                        "booking_time_stamps" => $dateTimeStamp
                    ]);
                    $insertedCount++;
               endif;
            endforeach;
            if($insertedCount > 0):
                Property::where('id',$request->input('property_id'))->update([
                    'ical_link'=>$request->input('ical_link')
                ]);
                return response()->json([
                    'status'=>"1",
                    'msg'=>"Calender Synchronized Successfully ! ({$insertedCount} bookings imported)"
                ]);
            else:
                return response()->json([
                    'status'=>"0",
                    'msg'=>"This ical link has been already imported"
                ]);
            endif;
        }catch (\Exception $e) {
            return response()->json([
                'msg'=>$e->getMessage()
            ]);
        }
    }

    public function getPropertyBookings(Request $request) {
        $propertyId = $request->input('property_id');
        if (empty($propertyId)) {
            return response()->json([]);
        }
        $bookings = PropertyBooking::where('property_id', $propertyId)->get();
        $today = now()->toDateString();
        $events = [];
        $upcoming = 0;
        $past = 0;

        foreach ($bookings as $booking) {
            if ($booking->end_date < $today) {
                $color = '#8592ad';
                $past++;
            } elseif ($booking->start_date <= $today && $booking->end_date >= $today) {
                $color = '#03c3ec';
                $upcoming++;
            } else {
                $color = '#696cff';
                $upcoming++;
            }
            $events[] = [
                'id'    => $booking->id,
                'title' => $booking->events ?? 'Booked',
                'start' => $booking->start_date,
                'end'   => $booking->end_date,
                'color' => $color,
            ];
        }

        return response()->json([
            'events'   => $events,
            'total'    => count($events),
            'upcoming' => $upcoming,
            'past'     => $past,
        ]);
    }

    public function manualBookingStore(Request $request) {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'booking_guest_name' => 'required|string|max:255',
            'booking_start_date' => 'required|date',
            'booking_end_date' => 'required|date|after:booking_start_date',
        ]);

        // Check overlap: allow same-day turnover (new check-in == existing check-out, or vice versa)
        $newStart = $request->input('booking_start_date');
        $newEnd = $request->input('booking_end_date');

        $exists = PropertyBooking::where('property_id', $request->input('property_id'))
            ->where('start_date', '<', $newEnd)
            ->where('end_date', '>', $newStart)
            ->where('start_date', '!=', $newEnd)
            ->where('end_date', '!=', $newStart)
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => '0',
                'msg' => 'Selected dates overlap with an existing booking.'
            ]);
        }

        $booking = PropertyBooking::create([
            'property_id' => $request->input('property_id'),
            'start_date' => $request->input('booking_start_date'),
            'end_date' => $request->input('booking_end_date'),
            'events' => $request->input('booking_guest_name'),
            'booking_time_stamps' => now(),
        ]);

        if ($booking) {
            return response()->json([
                'status' => '1',
                'msg' => 'Booking added successfully!'
            ]);
        }

        return response()->json([
            'status' => '0',
            'msg' => 'Failed to add booking.'
        ]);
    }

    public function deleteBooking(Request $request) {
        $request->validate([
            'booking_id' => 'required|exists:property_bookings,id',
        ]);

        $booking = PropertyBooking::find($request->input('booking_id'));
        if ($booking) {
            $booking->delete();
            return response()->json([
                'status' => '1',
                'msg' => 'Booking deleted successfully!'
            ]);
        }

        return response()->json([
            'status' => '0',
            'msg' => 'Booking not found.'
        ]);
    }

    public function reviewStore(PropertyReviewsRequest $request){
        $propertyReviews = PropertyReviews::create([
            'property_id'=>$request->input('property_id'),
            'reviews_heading'=>$request->input('reviews_heading'),
            'guest_name'=>$request->input('guest_name'),
            'place'=>$request->input('place'),
            'reviews'=>$request->input('reviews'),
            'rating'=>$request->input('rating'),
        ]);

        if($propertyReviews):
            return response()->json([
                'status'=>'1',
                'msg'=>"Reviews Added Successfully"
            ]);
        else:
            return response()->json([
                'status'=>'0',
                'msg'=>"Reviews Not Added, Please try again"
            ]);
        endif;

    }

    public function getPropertyReviews(Request $request){
        if($request->ajax()):
            $propertyReviews = PropertyReviews::where('property_id',$request->input('property_id'))->latest();
            return DataTables::of($propertyReviews)
            ->addIndexColumn()
            ->editColumn('reviews',function($row){
                return Helper::limit_text($row->reviews,3);
            })
            ->addColumn('action',function($row){
                $editBtn = '<a class="dropdown-item" href="javascript:void(0)" onclick="editReviwes('.$row->id.')"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                $deleteBtn = ' <a class="dropdown-item" href="javascript:void(0);" onclick="deleteReviews('.$row->id.')"><i class="bx bx-trash me-1"></i> Delete</a>';
                $actionBtn = '<div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
				'.$editBtn.$deleteBtn.'
                </div>
              </div>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        endif;
    }

    public function owmerInformationStore(Request $request){
        if($request->input('user_information_update')=='user_information_update'):
            $property = Property::findOrFail($request->input('property_id'));
            $owner = User::where('id',$property->user_id)->update([
                'name'=>$request->input('first_name')." ".$request->input('last_name'),
                'email'=>$request->input('primary_email'),
            ]);
            if($owner):
                $ownerInformation = UserInformation::where('user_id',$property->user_id)->update([
                    'secondary_email'=>$request->input('secondary_email'),
                    'phone'=>$request->input('phone'),
                    'alternate_phone'=>$request->input('alternate_phone'),
                    'address'=>$request->input('address'),
                    'city'=>$request->input('city'),
                    'state'=>$request->input('state'),
                    'year_purchased'=>$request->input('year_purchased'),
                    'about_you'=>$request->input('about_you')
                ]);
            endif;
            return response()->json([
               'status'=>'1',
               'msg'=>"Property Updated Successfully, Please wait Redirecting",
               'url'=>route('admin.property.index')
            ]);
        else:
            $owner = User::create([
                'name'=>$request->input('first_name')." ".$request->input('last_name'),
                'email'=>$request->input('primary_email'),
                'password'=>Hash::make('Hrbo#123#'),
                'type'=>"1",
            ]);
            $owner->assignRole('owner');
            if($owner):
                $ownerInformation = UserInformation::create([
                    'user_id'=>$owner->id,
                    'secondary_email'=>$request->input('secondary_email'),
                    'phone'=>$request->input('phone'),
                    'alternate_phone'=>$request->input('alternate_phone'),
                    'address'=>$request->input('address'),
                    'city'=>$request->input('city'),
                    'state'=>$request->input('state'),
                    'year_purchased'=>$request->input('year_purchased'),
                    'about_you'=>$request->input('about_you')
                ]);
                Property::where('id',$request->input('property_id'))->update([
                    'user_id'=>$owner->id
                ]);
            endif;
            return response()->json([
               'status'=>'1',
               'msg'=>"Property Create Successfully, Please wait Redirecting",
               'url'=>route('admin.property.index')
            ]);
        endif;
    }

    public function getRentalRatesById(Request $request) {
        $propertyRates=PropertyRate::findOrFail($request->input('id'));
        return response()->json([
            'status'=>'1',
            'data'=>$propertyRates
        ]);
    }

    public function rentalRatesUpdate(Request $request){
        $propertyRentalRatesUpdate = PropertyRate::findOrFail($request->input('id'))->update([
            "session_name"=>$request->input('session_name'),
            "start_date"=>$request->input('start_date'),
            "end_date"=>$request->input('end_date'),
            "nightly_rate"=>$request->input('nightly_rate'),
            "weekly_rate"=>$request->input('weekly_rate'),
            "weekend_rate"=>$request->input('weekend_rate'),
            "monthly_rate"=>$request->input('monthly_rate'),
            "minimum_stay"=>$request->input('minimum_stay'),
        ]);
        if($propertyRentalRatesUpdate):
            return response()->json([
                'status'=>200,
                'msg'=>"Rental Rate Update Successfully"
            ]);
        else:
            return response()->json([
                'status'=>400,
                'msg'=>"Rental Rate Not Update, Please try again !"
            ]);
        endif;
    }

    public function deleteRentalRates(Request $request){
        $deletePropertyRate =PropertyRate::findOrFail($request->input('id'))->delete();
        if($deletePropertyRate):
            return response()->json([
                "status"=>200,
                "msg"=>"Rental Rates Delete Successfully"
            ]);
        else:
            return response()->json([
                "status"=>400,
                "msg"=>"Rental Retes not delete, Please try again !"
            ]);
        endif;
    }


    public function editPropertyReviews(Request $request){
        $propertyReviews = PropertyReviews::findOrfail($request->input('id'));
        return response()->json([
            'status'=>"1",
            'data'=>$propertyReviews
        ]);
    }

    public function reviewsRatingUpdate(Request $request) {
        $propertyReviews = PropertyReviews::findOrFail($request->input('id'))->update([
            'reviews_heading'=>$request->input('reviews_heading'),
            'guest_name'=>$request->input('guest_name'),
            'place'=>$request->input('place'),
            'reviews'=>$request->input('reviews'),
            'rating_update'=>$request->input('rating_update'),
        ]);
        if($propertyReviews):
            return response()->json([
                'status'=>200,
                'msg'=>"Rating and Reviews Update Successfully"
            ]);
        else:
            return response()->json([
                'status'=>400,
                'msg'=>"Reviews and rating not Updated Please try again!"
            ]);

        endif;
    }

    public function deleteReviewsRating(Request $request) {
        $deletePropertyRating = PropertyReviews::findoRFail($request->input('id'))->delete();
        if($deletePropertyRating):
            return response()->json([
                "status"=>200,
                "msg"=>"Reviews and Rating Delete Successfully"
            ]);
        else:
            return response()->json([
                "status"=>400,
                "msg"=>"Reviews and Rating, Please try again !"
            ]);
        endif;
    }

    public function addFeaturedProperty(Request $request){
        if($request->input('status')=='1'):
            $featureProperty =  FeaturedProperty::create([
                'property_id'=>$request->input('id')
            ]);
            if($featureProperty):
                return response()->json([
                    'status'=>200,
                    'msg'=>"Feature Property Added successfully !"
                ]);
            else:
                return response()->json([
                    'status'=>500,
                    'msg'=>"Feature Property Not Added,Please try again !"
                ]);
            endif;
        else:
            $featureProperty = FeaturedProperty::where('property_id',$request->input('id'))->delete();
            if($featureProperty):
                return response()->json([
                    'status'=>200,
                    'msg'=>"Feature Property Removed successfully !"
                ]);
            else:
                return response()->json([
                    'status'=>500,
                    'msg'=>"Feature Property Not removed,Please try again !"
                ]);
            endif;
        endif;
    }

    public function addRecommendation(Request $request){
        if($request->input('status')=='1'):
            Recommendation::create([
                'property_id'=>$request->input('id'),
            ]);
            return response()->json([
                'status'=>200,
                'msg'=>"Property Recommended successfully !"
            ]);
        else:
            Recommendation::where('property_id',$request->input('id'))->delete();
            return response()->json([
                'status'=>200,
                'msg'=>"Property Recommendation Removed successfully !"
            ]);
        endif;
    }

    public function propertyApproved(Request $request){
        $approvedProperty = Property::where('id',$request->input('id'))->update([
            'property_approved'=>$request->input('status'),
            'subscription_date'=>$request->input('status')==1?date('Y-m-d'):null,
        ]);
        if($approvedProperty):
            return response()->json([
                'status'=>200,
                'msg'=>$request->input('status')==1?"Property Approved successfully !":"Property UnApproved Successfully !",
            ]);
        else:
            return response()->json([
                'status'=>500,
                'msg'=>"Property Not Approved,Please try again !"
            ]);
        endif;
    }

    public function deleteProperty(Request $request) {
        $propertyDelete  = Property::findOrFail($request->input('id'))->delete();
        if($propertyDelete):
            return response()->json([
                'status'=>200,
                'msg'=>"Property Deleted SuccessFully !",
            ]);
        else:
            return response()->json([
                'status'=>500,
                'msg'=>'Property Not Deleted Please try again',
            ]);
        endif;
    }



}
