<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\FeaturedProperty;
use App\Models\Recommendation;
use App\Http\Helper\Helper;
use App\Models\PropertyBooking;
use App\Models\PropertyExportIcal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class HomeController extends Controller
{
    public function index() {
        $featuredProperties = FeaturedProperty::latest()->get();
        return view('frontend.index',compact('featuredProperties'));
    }

    public function destination() {
        $countries = Country::get();
        return view('frontend.destination',compact('countries'));
    }

    public function contact() {
        return view('frontend.contact-us');
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'phone'   => 'required|string|max:20',
            'email'   => 'required|email|max:150',
            'message' => 'required|string|max:2000',
            'captcha' => 'required|captcha',
        ], [
            'captcha.required' => 'Please enter the captcha.',
            'captcha.captcha'  => 'Invalid captcha. Please try again.',
        ]);

        try {
            $body = "New contact message from rentforvacations.com\n\n"
                  . "Name: {$validated['name']}\n"
                  . "Phone: {$validated['phone']}\n"
                  . "Email: {$validated['email']}\n\n"
                  . "Message:\n{$validated['message']}\n";

            Mail::raw($body, function ($m) use ($validated) {
                $m->to('support@rentforvacations.com')
                  ->subject('New Contact Message - ' . $validated['name'])
                  ->replyTo($validated['email'], $validated['name']);
            });

            return response()->json([
                'status' => 200,
                'msg'    => 'Thank you! Your message has been sent.',
            ]);
        } catch (\Exception $e) {
            Log::error('Contact form email failed: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'msg'    => 'Failed to send your message. Please try again later.',
            ], 500);
        }
    }

    public function bookNow() {
        return view('frontend.book-now');
    }

    public function register() {
        return view('frontend.register');
    }

    public function logIn() {
        return view('frontend.log-in');
    }

    public function forgot() {
        return view('frontend.forgot');
    }

    public function recomended() {
        $recommendedProperties = Recommendation::with('property')->latest()->get();
        return view('frontend.recommended', compact('recommendedProperties'));
    }

    public function package() {
        return view('frontend.package');
    }

    public function genratePropertIcalLink($property_id){
        $propertyBookings = PropertyBooking::where('property_id',$property_id)->get();
        define('ICAL_FORMAT', 'Ymd\THis\Z');
        $icalObject = "BEGIN:VCALENDAR
        VERSION:2.0
        METHOD:PUBLISH
        PRODID:-//Property Booking//EN\n";
        foreach ($propertyBookings as $event) {
           $icalObject .=
           "BEGIN:VEVENT
           DTSTART:" . date(ICAL_FORMAT, strtotime($event->start_date)) . "
           DTEND:" . date(ICAL_FORMAT, strtotime($event->end_date)) . "
           DTSTAMP:" . date(ICAL_FORMAT, strtotime($event->created_at)) . "
           SUMMARY:$event->events
           UID:".uniqid()."
           LAST-MODIFIED:" . date(ICAL_FORMAT, strtotime($event->updated_at)) . "
           END:VEVENT\n";
       }
       // close calendar
        $icalObject .= "END:VCALENDAR";
        $filename = $property_id.time().'.ics';
        \Storage::put('public/ical_link/'.$filename,$icalObject);
        PropertyExportIcal::create([
            'property_id'=>$property_id,
            'ical_file_name'=>$filename
        ]);
        return response()->json([
            'status'=>200,
            'msg'=>"Ical Genrate Successfully",
            'url'=>url('storage/ical_link/'.$filename)
        ]  , 200);
    }

    public function getSearchDestintaion(Request $request)
    {
        try {
            $keyword = trim($request->keyword);

            if (!$keyword || strlen($keyword) < 3) {
                return response()->json([]);
            }

            /* =====================
            1️⃣ SUB CITY
            ====================== */
            $subCities = DB::table('sub_cities')
                ->join('cities', 'cities.id', '=', 'sub_cities.city_id')
                ->join('regions', 'regions.id', '=', 'sub_cities.region_id')
                ->join('states', 'states.id', '=', 'sub_cities.state_id')
                ->join('countries', 'countries.id', '=', 'sub_cities.country_id')
                ->whereNull('sub_cities.deleted_at')
                ->where('sub_cities.status', '1')
                ->whereNull('countries.deleted_at')
                ->where('states.status', '1')
                ->where('sub_cities.name', 'LIKE', "%{$keyword}%")
                ->select([
                    'countries.id as country_id',
                    'states.id as state_id',
                    'regions.id as region_id',
                    'cities.id as city_id',
                    'sub_cities.id as sub_city_id',

                    'countries.name as country_name',
                    'states.name as state_name',
                    'regions.name as region_name',
                    'cities.name as city_name',
                    'sub_cities.name as sub_city_name',

                    DB::raw("'sub_city' as type"),
                ]);

            /* =====================
            2️⃣ CITY
            ====================== */
            $cities = DB::table('cities')
                ->join('regions', 'regions.id', '=', 'cities.region_id')
                ->join('states', 'states.id', '=', 'cities.state_id')
                ->join('countries', 'countries.id', '=', 'cities.country_id')
                ->whereNull('countries.deleted_at')
                ->whereNull('cities.deleted_at')
                ->where('cities.status', '1')
                ->where('states.status', '1')
                ->where('cities.name', 'LIKE', "%{$keyword}%")
                ->select([
                    'countries.id as country_id',
                    'states.id as state_id',
                    'regions.id as region_id',
                    'cities.id as city_id',
                    DB::raw('NULL as sub_city_id'),

                    'countries.name as country_name',
                    'states.name as state_name',
                    'regions.name as region_name',
                    'cities.name as city_name',
                    DB::raw('NULL as sub_city_name'),

                    DB::raw("'city' as type"),
                ]);

            /* =====================
            3️⃣ REGION
            ====================== */
            $regions = DB::table('regions')
                ->join('states', 'states.id', '=', 'regions.state_id')
                ->join('countries', 'countries.id', '=', 'regions.country_id')
                ->whereNull('regions.deleted_at')
                ->where('regions.status', '1')
                ->where('states.status', '1')
                ->whereNull('countries.deleted_at')
                ->where('regions.name', 'LIKE', "%{$keyword}%")
                ->select([
                    'countries.id as country_id',
                    'states.id as state_id',
                    'regions.id as region_id',
                    DB::raw('NULL as city_id'),
                    DB::raw('NULL as sub_city_id'),

                    'countries.name as country_name',
                    'states.name as state_name',
                    'regions.name as region_name',
                    DB::raw('NULL as city_name'),
                    DB::raw('NULL as sub_city_name'),

                    DB::raw("'region' as type"),
                ]);

            /* =====================
            4️⃣ STATE
            ====================== */
            $states = DB::table('states')
                ->join('countries', 'countries.id', '=', 'states.country_id')
                ->whereNull('states.deleted_at')
                ->where('states.status', '1')
                ->whereNull('countries.deleted_at')
                ->where('states.name', 'LIKE', "%{$keyword}%")
                ->select([
                    'countries.id as country_id',
                    'states.id as state_id',
                    DB::raw('NULL as region_id'),
                    DB::raw('NULL as city_id'),
                    DB::raw('NULL as sub_city_id'),

                    'countries.name as country_name',
                    'states.name as state_name',
                    DB::raw('NULL as region_name'),
                    DB::raw('NULL as city_name'),
                    DB::raw('NULL as sub_city_name'),

                    DB::raw("'state' as type"),
                ]);

            /* =====================
            🔗 UNION
            ====================== */
            $data = $subCities
                ->unionAll($cities)
                ->unionAll($regions)
                ->unionAll($states)
                ->limit(20)
                ->get();

            /* =====================
            🎯 FINAL MAPPING
            ====================== */
            $result = $data->map(function ($row) {

                $fullAddress = collect([
                    $row->sub_city_name,
                    $row->city_name,
                    $row->region_name,
                    $row->state_name,
                    $row->country_name,
                ])->filter()->implode(', ');

                return [
                    'type'         => $row->type,
                    'country_id'   => $row->country_id,
                    'state_id'     => in_array($row->type, ['state','region','city','sub_city']) ? $row->state_id : null,
                    'region_id'    => in_array($row->type, ['region','city','sub_city']) ? $row->region_id : null,
                    'city_id'      => in_array($row->type, ['city','sub_city']) ? $row->city_id : null,
                    'sub_city_id'  => $row->type === 'sub_city' ? $row->sub_city_id : null,
                    'full_address' => $fullAddress,
                ];
            });

            return response()->json($result);

        } catch (\Throwable $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function privacyPolicy() {
        return view('frontend.privacy-policy');
    }

    public function termsAndConditions() {
        return view('frontend.terms-and-conditions');
    }

    public function notFound() {
        return view('frontend.property-not-found');
    }



}
