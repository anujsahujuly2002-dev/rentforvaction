<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Helper\Helper;
use App\Http\Requests\Owner\PrepertyReviews;
use App\Http\Requests\Owner\PropertyInformationRequest;
use App\Http\Requests\Owner\RentalRateRequest;
use App\Models\Aminities;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Property;
use App\Models\PropertyAmenites;
use App\Models\PropertyBooking;
use App\Models\PropertyGalleryImage;
use App\Models\PropertyRate;
use App\Models\PropertyReviews;
use App\Models\PropertySuitablity;
use App\Models\PropertyTypes;
use App\Models\Region;
use App\Models\State;
use App\Models\SubAmenities;
use App\Models\SubCity;
use App\Models\ThirdLevelAmenities;
use Auth;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\PropertyInquiry;
use App\Mail\PropertyInquiryConfirmation;
use App\Models\Inquiry;


class PropertyController extends Controller
{
    public function create(Request $request) {
        $properties_suitablities = PropertySuitablity::latest()->get();
        $properties_type =PropertyTypes::latest()->get();
        $countries = Country::latest()->get();
        $properties = "";
        $states = "";
        $regions = "";
        $cities = "";
        $subCities="";
        if(!is_null($request->id) && !is_null($request->get('type'))):
            $properties = Property::findOrFail($request->id);
            $states = State::where('country_id',$properties->country_id)->get();
            $regions = Region::where('state_id',$properties->state_id)->get();
            $cities = City::where('region_id',$properties->region_id)->get();
            $subCities = SubCity::where('city_id',$properties->city_id)->get();
        endif;
        return view('owner.property.create',compact('properties_suitablities','properties_type','countries','properties','states','regions','cities','subCities'));
    }

    public function storePropertyInformation(PropertyInformationRequest $request){
        if($request->hasfile('property_photo')):
            $path = storage_path('public/upload/property_image/main_image/');
            if(file_exists($path.$request->input('property_old_image'))):
                unlink($path.$request->input('property_old_image'));
            endif;
            $image = $request->file('property_photo');
            $ext = "webp";
            $convertImage = \Image::make($image->getRealPath())->resize(650, 960)->encode($ext,100);
            $originalImageName = uniqid().'.'.$ext;
            \Storage::put('public/upload/property_image/main_image/'.$originalImageName, $convertImage);
        endif;
        if($request->input('property_id') !=null):
            $property_information = Property::where('id',$request->input('property_id'))->update([
                'added_by'=>Auth::user()->id,
                'property_name'=>$request->input('property_name'),
                'property_suitablity_id'=>json_encode($request->input('property_suitablity')),
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
        else:
            $property_information = Property::create([
                'user_id'=>auth()->user()->id,
                'added_by'=>auth()->user()->id,
                'property_name' =>$request->input('property_name'),
                'property_suitablity_id'=>json_encode($request->input('property_suitablity')),
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
        endif;

       if($property_information):
            return response()->json([
                'status'=>200,
                "msg"=>$request->input('property_id') !=null?"Property Information store sucessfully !, Please Wait redirecting...":"Property Information Updated sucessfully !, Please Wait redirecting...",
                "url"=> route('owner.property.amenities',['id'=>$property_information->id??$request->input('property_id'),'type'=>"edit"]),
            ]);
        else:

            return response()->json([
                'status'=>500,
                "msg"=>"Property Information Not Stored,Please Try again..",
            ]);

       endif;
    }

    public function amienites(Request $request) {
        $properties = '';
        if($request->get('type')=='edit'):
            $properties = Property::findOrFail($request->input('id'));
        endif;
        $ammienites = Aminities::where('status','1')->get();
        return view('owner.property.amenites',compact('ammienites','properties'));
    }

    public function aminitiesStore(Request $request) {
        if($request->subaminities):
            foreach($request->subaminities as $key => $subaminites):
                $ammienites = SubAmenities::where('id',$subaminites)->first();
                $checkAmenites = PropertyAmenites::where(['property_id'=>$request->input('property_id'),'sub_amenites_id'=>$subaminites])->first();
                if($checkAmenites !=null):
                    $checkAmenites->delete();
                endif;
                $propertyAmenities = PropertyAmenites::create([
                    'property_id'=>$request->input('property_id'),
                    'amenites_id'=> $ammienites->amenities_id,
                    'sub_amenites_id'=>$subaminites,
                    'description'=>array_key_exists($key,$request->description['subAmenities'])?$request->description['subAmenities'][$key]:null,
                ]);
            endforeach;
        endif;

        if($request->childAmenities):
            foreach($request->childAmenities as $key=> $childAmenities):
                $subaminites = ThirdLevelAmenities::where('id',$childAmenities)->first();
                $checkChildAmenites = PropertyAmenites::where(['property_id'=>$request->input('property_id'),'child_amenites_id'=>$childAmenities])->first();
                if($checkChildAmenites !=null):
                    $checkChildAmenites->delete();
                endif;
                $propertyAmenities = PropertyAmenites::create([
                    'property_id'=>$request->input('property_id'),
                    'amenites_id'=> $subaminites->amenities_id,
                    'sub_amenites_id'=>$subaminites->sub_amenities_id,
                    'child_amenites_id'=>$childAmenities,
                    'description'=>array_key_exists($key,$request->description['chlidrenAmenites'])?$request->description['chlidrenAmenites'][$key]:null,
                ]);
            endforeach;
        endif;
        return response()->json([
            'status'=>200,
            'msg'=>$request->input('type') !='edit'?"Amenities Added Sucessfully !, Please wait redirecting ...":"Amenities Updated Sucessfully !, Please wait redirecting ...",
            'url'=>route('owner.property.location',$request->input('type') !='edit'?['id'=>$request->input('property_id')]:['id'=>$request->input('property_id'),'type'=>'edit'])
        ]);
    }

    public function location(Request $request){
        $properties = '';
        if($request->get('type')=='edit'):
            $properties = Property::findOrFail($request->input('id'));
        endif;
        return view('owner.property.location',compact('properties'));
    }

    public function locationStore(Request $request) {
        // dd($request->all());
         $propertyLocation = Property::where('id',$request->input('property_id'))->update([
            'address'=>$request->input('location'),
            'iframe_link'=>$request->input('iframe_link'),
            'latitude'=>$request->input('latitude')??Helper::getCoordinates($request->input('location'))['latitude'],
            'longitude'=>$request->input('longitude')??Helper::getCoordinates($request->input('location'))['longitude'],
        ]);

        if($propertyLocation){
            return response()->json([
                'status'=>200,
                'msg'=>$request->input('type') !='edit'?"Property Location Added SuccessFully !, Please wait redirecting":"Property Location Updated SuccessFully !, Please wait redirecting",
                'url'=>route('owner.property.rental.rates',$request->input('type') !='edit'?['id'=>$request->input('property_id')]:['id'=>$request->input('property_id'),'type'=>'edit'])
            ]);
        }else{
            return response()->json([
                'status'=>500,
                "msg"=>"Property Location Not Added,Please Try again..",
            ]);
        }

    }

    public function rentalRates(Request $request) {
        $currencies =Currency::latest()->get();
        $properties='';
        if($request->get('type')=='edit'):
            $properties = Property::findOrFail($request->input('id'));
        endif;
        return view('owner.property.rental-rates',compact('currencies','properties'));
    }

    public function getPropertyRates (Request $request){
        if($request->ajax()):
            $property_rates = PropertyRate::where('property_id',$request->property_id)->latest();
            return DataTables::of($property_rates)
            ->addIndexColumn()
            ->addColumn('action',function($row){
                $actionBtn = ' <a href="javascript:void(0);" class="button gray" onclick="editRentalRates('.$row->id.')"><i class="fa fa-pencil-square-o"></i></a><a href="javascript:void(0);" class="button gray" style="background: #ff0000;" onclick="deleteRentalRates('.$row->id.')"><i class="fa fa-trash-o"></i></a>';
                return $actionBtn;
            })

            ->rawColumns(['action'])
            ->make(true);
        endif;
    }

    public function rentalRatesStore(Request $request) {
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
                'status'=>200,
                "msg"=>"Rate Added Succesfully"
            ]);
        else:
            return response()->json([
                'status'=>500,
                "msg"=>"Rate not added Please Try again",
            ]);
        endif;
    }

    public function addMoreRentalRates(RentalRateRequest $request) {
        $propertyRental = Property::where('id',$request->input('property_id'))->update([
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
            'smoking_allowed'=>$request->input('smoked_allowed'),
            'pet_allowed'=>$request->input('pet_allowed'),
        ]);

        if($propertyRental):
            return response()->json([
                "status"=>200,
                "msg"=>$request->input('type') !='edit'?"Rental Rate Added Successfully, Please Wait redirecting....":"Rental Rate Updated Successfully, Please Wait redirecting....",
                "url"=>route('owner.property.gallery.image',$request->input('type') !='edit'?['id'=>$request->input('property_id')]:['id'=>$request->input('property_id'),'type'=>'edit'])
            ]);
        else:
            return response()->json([
                "status"=>500,
                "msg"=>"Rental Rates Not Added Please ,Please Try again"
            ]);
        endif;
    }

    public function propertyGalleryImage(Request $request) {
        $properties='';
        if($request->get('type')=='edit'):
            $properties = Property::findOrFail($request->get('id'));
        endif;
        return view('owner.property.gallery-image',compact('properties'));
    }

    public function galleryImageStore(Request $request) {
        $propertyGalleryImage ='';
        if($request->input('totalFiles')>0):
            for($x = 0; $x < $request->input('totalFiles'); $x++):
                if($request->hasFile("files".$x)):
                    $image = $request->file('files'.$x);
                    $ext = "webp";
                    $convertImage = \Image::make($image->getRealPath())->resize(1000, 720)->encode($ext,100);
                    $originalImageName = uniqid().'.'.$ext;
                    Storage::put('public/upload/property_image/gallery_image/'.$request->input("property_id").'/'.$originalImageName, $convertImage);
                    $propertyGalleryImage = PropertyGalleryImage::create([
                        "property_id"=>$request->input("property_id"),
                        "image_name"=>$originalImageName
                    ]);
                endif;
            endfor;
        endif;
        return response()->json([
            "status"=>200,
            "msg"=>$request->input('type') !='edit'?"Gallery Photos Added Successfully, Please Wait redirecting....":"Gallery Photos Updated Successfully, Please Wait redirecting....",
            "url"=>route('owner.property.rental.policies',$request->input('type') !='edit'?['id'=>$request->input('property_id')]:['id'=>$request->input('property_id'),'type'=>'edit'])
        ]);
    }

    public function deleteGalleryImage(Request $request) {
        $galleryImage = PropertyGalleryImage::findOrFail($request->input('id'));
        $path = 'public/upload/property_image/gallery_image/'.$galleryImage->property_id.'/'.$galleryImage->image_name;
        if(Storage::exists($path)):
            Storage::delete($path);
        endif;
        $deleted = $galleryImage->delete();
        if($deleted):
            return response()->json([
                'status'=>200,
                'msg'=>"Gallery Image Deleted Successfully."
            ]);
        else:
            return response()->json([
                'status'=>500,
                'msg'=>"Gallery Image Not Deleted, Please Try Again."
            ]);
        endif;
    }

    public function rentalPolicies(Request $request) {
        $properties='';
        if($request->get('type')=='edit'):
            $properties = Property::findOrFail($request->get('id'));
        endif;
        return view('owner.property.rental-policies',compact('properties'));
    }

    public function rentalPoliciesStore(Request $request) {
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
                'status'=>200,
                'msg'=>$request->input('type') !='edit'?"Rental Policies Added SuccessFully":"Rental Policies Updated SuccessFully",
                'url'=>route('owner.property.calender',$request->input('type') !='edit'?['id'=>$request->input('property_id')]:['id'=>$request->input('property_id'),'type'=>'edit'])
            ]);
        endif;
    }

    public function calender(Request $request) {
        $properties='';
        if($request->get('type')=='edit'):
            $properties = Property::findOrFail($request->get('id'));
        endif;
        return view('owner.property.calender',compact('properties'));
    }

    public function calenderSyncronization(Request $request) {
        try{
            $ical_response = file_get_contents($request->input('import_calender_url'));
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
            $property_booking = "";
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
                    'ical_link'=>$request->input('import_calender_url')
                ]);
                return response()->json([
                    'status'=>200,
                    'msg'=>"Calender Synchronized Successfully ! ({$insertedCount} bookings imported)"
                ]);
            else:
                return response()->json([
                    'status'=>500,
                    'msg'=>"This ical link has been already imported"
                ],500);
            endif;
        }catch (\Exception $e) {
            return response()->json([
                'status'=>500,
                'msg'=>$e->getMessage()
            ],500);
        }
    }

    public function reviews() {
        return view('owner.property.property-reviews');
    }

    public function reviewsStore(PrepertyReviews $request) {
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
                'status'=>200,
                'msg'=>"Reviews Added Successfully"
            ]);
        else:
            return response()->json([
                'msg'=>"Reviews Not Added, Please try again"
            ],500);
        endif;
    }

    public function getPropertyReviews(Request $request){
        if($request->ajax()):
            $propertyReviews = PropertyReviews::where('property_id',$request->input('property_id'))->latest();
            return DataTables::of($propertyReviews)
            ->addIndexColumn()
            ->addColumn('action',function($row){
                $actionBtn = ' <a href="javascript:void(0);" class="button gray" onclick="editPropertyReviews('.$row->id.')"><i class="fa fa-pencil-square-o"></i></a><a href="javascript:void(0);" class="button gray" style="background: #ff0000;" onclick="propertyReviewsDelete('.$row->id.');"><i class="fa fa-trash-o"></i></a>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        endif;
    }

    public function deleteReviews(Request $request) {
        $id = $request->json()->all();
        $deletePropertyReviews = PropertyReviews::findOrFail($id['id'])->delete();
        if($deletePropertyReviews):
            return response()->json([
                'status'=>200,
                'msg'=>"Reviews Delete successfully !"
            ]);
        else:

            return response()->json([
                'status'=>500,
                'msg'=>"Reviews Not delete Please Try again"
            ]);
        endif;
    }

    public function deletePropertyRates(Request $request){
        $propertyRatesDelete = PropertyRate::findOrFail($request->input('id'))->delete();
        if($propertyRatesDelete):
            return response()->json([
                'status'=>200,
                'msg'=>"Rental Rates Delete Successfully."
            ]);
        else:
          return response()->json([
                'status'=>500,
                'msg'=>"Rental Rates Not Delete Successfully."
            ]);
        endif;
    }

    public function editRentalRates(Request $request){
        $id = $request->json()->all();
        $rentalRates = PropertyRate::findOrFail($id['id']);
        $rentalRates->start_date = Carbon::parse($rentalRates->start_date)->format('Y-m-d');
        $rentalRates->end_date = Carbon::parse($rentalRates->end_date)->format('Y-m-d');
        return response()->json([
            'status'=>200,
            'data'=>$rentalRates,
        ]);
    }

    public function updateRentalRates(Request $request){
        $propertyRates = PropertyRate::where('id',$request->input('id'))->update([
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
                'status'=>200,
                "msg"=>"Rate Update Succesfully"
            ]);
        else:
            return response()->json([
                'status'=>500,
                "msg"=>"Rate not Update Please Try again",
            ]);
        endif;
    }

    public function editPropertyRevies(Request $request){
        $id = $request->json()->all();
        $propertyReviews = PropertyReviews::findOrFail($id['id']);
        return response()->json([
            'status'=>200,
            'data'=>$propertyReviews,
        ]);
    }

    public function updatePropertyRevies(Request $request){
        $propertyReviews = PropertyReviews::where('id',$request->input('id'))->update([
            'reviews_heading'=>$request->input('reviews_heading'),
            'guest_name'=>$request->input('guest_name'),
            'place'=>$request->input('place'),
            'reviews'=>$request->input('reviews'),
            'rating'=>$request->input('rating'),
        ]);

        if($propertyReviews):
            return response()->json([
                'status'=>200,
                'msg'=>"Reviews Update Successfully"
            ]);
        else:
            return response()->json([
                'msg'=>"Reviews Not Update, Please try again"
            ],500);
        endif;
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
                'msg' => 'Booking added successfully.'
            ]);
        }

        return response()->json([
            'status' => '0',
            'msg' => 'Failed to add booking.'
        ]);
    }

    public function deleteBooking(Request $request) {
        $booking = PropertyBooking::find($request->input('booking_id'));
        if ($booking) {
            $booking->delete();
            return response()->json([
                'status' => '1',
                'msg' => 'Booking deleted successfully.'
            ]);
        }
        return response()->json([
            'status' => '0',
            'msg' => 'Booking not found.'
        ]);
    }

    public function enquiry(Request $request)
    {
        $property = null;
        if ($request->id && $request->type === 'edit') {
            $property = Property::where('id', $request->id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
        }
        $ownerProperties = Property::where('user_id', Auth::id())->get();
        return view('owner.property.enquiry', compact('property', 'ownerProperties'));
    }

    public function submitEnquiry(Request $request)
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
        ]);

        $property = Property::with('user')
            ->where('id', $request->property_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$property) {
            return response()->json(['status' => 422, 'msg' => 'Invalid property selected.'], 422);
        }

        try {
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

            if ($ownerEmail) {
                Mail::to($ownerEmail)->send(new PropertyInquiry($inquiryData));
                Mail::to('varunchanana1788@gmail.com')->send(new PropertyInquiry($inquiryData));
            }

            Mail::to($request->email)->send(new PropertyInquiryConfirmation($inquiryData));

            Inquiry::create(array_merge($inquiryData, ['source' => 'owner']));

            return response()->json(['status' => 200, 'msg' => 'Enquiry sent successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'msg' => 'Failed to send enquiry. Please try again.'], 500);
        }
    }
}
