<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\Admin\Destination\Country\CountryRequest;
use App\Http\Requests\Admin\Destination\State\StateRequest;
use App\Http\Requests\Admin\Destination\Region\RegionRequest;
use App\Http\Requests\Admin\Destination\City\CityRequest;
use App\Http\Requests\Admin\Destination\SubCity\SubCityRequest;
use App\Models\Country;
use DataTables;
use App\Models\State;
use App\Models\Region;
use App\Models\City;
use App\Models\SubCity;
use Spatie\Permission\Exceptions\UnauthorizedException;

class DestinationController extends Controller
{
    public function countryList(Request $request){
        if(!Auth::user()->can('country-list')){
            throw UnauthorizedException::forPermissions(['country-list']);
        }
        if($request->ajax()):
            $country = Country::latest();
            return DataTables::of($country)
            ->addIndexColumn()
            ->editColumn('name',function($row){
                return ucfirst($row->name);
            })
            ->addColumn('action',function($row){
                $user = Auth::user();
                $editBtn='';
                $deleteBtn='';
                if($user->can('country-edit')):
                    $editBtn = '<a class="dropdown-item" href="'.route('admin.destination.country.edit',encrypt($row->id)).'"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                endif;
                if($user->can('country-delete')):
                    $deleteBtn = ' <a class="dropdown-item" href="javascript:void(0);" onclick="deleteCountry('.$row->id.')"><i class="bx bx-trash me-1"></i> Delete</a>';
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
            ->rawColumns(['action'])
            ->make(true);
        endif;
        return view('admin.destination.country.index');
    }

    public function countryCreate(){
        if(!Auth::user()->can('country-create')){
            throw UnauthorizedException::forPermissions(['country-create']);
        }
        return view('admin.destination.country.create');
    }

    public function countryStore(CountryRequest $request) {
        $country = Country::create([
            'name'=>strtolower($request->input('country_name'))
        ]);
        if($country):
            return response()->json([
                'msg'=>"Country created Successfully,Please wait redirecting....",
                'url'=>route('admin.destination.country.index')
            ]);
        else:
            return response()->json([
                'msg'=>"Country Not created ,Please try again....",
            ]);
        endif;
    }

    public function countryEdit($id) {
        if(!Auth::user()->can('country-edit')){
            throw UnauthorizedException::forPermissions(['country-edit']);
        }
        $country = Country::findorFail(decrypt($id));
        return view("admin.destination.country.edit",compact('country'));
    } 

    public function countryUpdate(CountryRequest $request){
        $country = Country::findOrFail($request->input('id'))->update([
            'name'=>strtolower($request->input('country_name'))
        ]);
        if($country):
            return response()->json([
                'msg'=>"Country Updated Successfully,Please wait redirecting....",
                'url'=>route('admin.destination.country.index')
            ]);
        else:
            return response()->json([
                'msg'=>"Country Not Updated ,Please try again....",
            ]);
        endif;
    }

    public function countryDelete (Request $request){
        if(!Auth::user()->can('country-delete')){
            throw UnauthorizedException::forPermissions(['country-delete']);
        }
        $country = Country::findOrFail($request->input('id'))->delete();
        if($country):
            return response()->json([
                'msg'=>"Country Deletes Successfully,Please wait redirecting....",
                'url'=>route('admin.destination.country.index')
            ]);
        else:
            return response()->json([
                'msg'=>"Country Not Delete ,Please try again....",
            ]);
        endif;

    }

    public function stateList(Request $request) {
        if(!Auth::user()->can('state-list')){
            throw UnauthorizedException::forPermissions(['state-list']);
        }
        if($request->ajax()):
                $state = State::with('country')->latest();
                return DataTables::of($state)
                ->addIndexColumn()
                ->addColumn('country_name',function($row){
                    return ucfirst($row->country->name);
                })
                ->editColumn('name',function($row){
                    return ucfirst($row->name);
                })
                ->addColumn('action',function($row){
                    $user = Auth::user();
                    $editBtn='';
                    $deleteBtn='';
                    if($user->can('state-edit')):
                        $editBtn = '<a class="dropdown-item" href="'.route('admin.destination.state.edit',encrypt($row->id)).'"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                    endif;
                    if($user->can('state-delete')):
                        $deleteBtn = ' <a class="dropdown-item" href="javascript:void(0);" onclick="deleteState('.$row->id.')"><i class="bx bx-trash me-1"></i> Delete</a>';
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
                ->rawColumns(['action'])
                ->make(true);
        endif;
        return view('admin.destination.state.index');
    }

    public function stateCreate() {
        if(!Auth::user()->can('state-create')){
            throw UnauthorizedException::forPermissions(['state-create']);
        }
        $countries = Country::latest()->get();
        return view('admin.destination.state.create',compact('countries'));
    }

    public function stateStore (StateRequest $request) {
        $state = State::create([
            'country_id'=>$request->input('country_name'),
            'name'=>strtolower($request->input('state_name')),
        ]);
        if($state):
            return response()->json([
                'msg'=>"State Created Successfully, Please Wait redirecting....",
                'url'=>route('admin.destination.state.index')
            ]);
        else:
            return response()->json([
                'msg'=>"State Not Created , Please Try again!",
            ]);
        endif;
    }

    public function stateEdit($id) {
        if(!Auth::user()->can('state-edit')){
            throw UnauthorizedException::forPermissions(['state-edit']);
        }
        $countries = Country::latest()->get();
        $state = State::findOrFail(decrypt($id));
        return view('admin.destination.state.edit',compact('countries','state'));

    }

    public function stateUpdate(StateRequest $request) {
        $state = State::findOrFail($request->input('id'))->update([
            'country_id'=>$request->input('country_name'),
            'name'=>strtolower($request->input('state_name')),
        ]);
        if($state):
            return response()->json([
                'msg'=>"State Update Successfully, Please Wait redirecting....",
                'url'=>route('admin.destination.state.index')
            ]);
        else:
            return response()->json([
                'msg'=>"State Not Update , Please Try again!",
            ]);
        endif;
    }

    public function stateDelete (Request $request ) {
        if(!Auth::user()->can('state-delete')){
            throw UnauthorizedException::forPermissions(['state-delete']);
        }
        $state = State::findOrFail($request->input('id'))->delete();
        if($state):
            return response()->json([
                'msg'=>"State Delete Successfully, Please Wait redirecting....",
                'url'=>route('admin.destination.state.index')
            ]);
        else:
            return response()->json([
                'msg'=>"State Not Delete , Please Try again!",
            ]);
        endif;

    }

    public function regionList (Request $request) {
        if(!Auth::user()->can('region-list')){
            throw UnauthorizedException::forPermissions(['region-list']);
        }
        if($request->ajax()):
            $region = region::with('state','country')->latest();
            return DataTables::of($region)
            ->addIndexColumn()
            ->addColumn('country_name',function($row){
                return ucfirst($row->country->name);
            })
            ->addColumn('state_name',function($row){
                return ucfirst($row->state->name);
            })
            ->editColumn('name',function($row){
                return ucfirst($row->name);
            })
            ->addColumn('action',function($row){
                $user = Auth::user();
                $editBtn='';
                $deleteBtn='';
                if($user->can('region-edit')):
                    $editBtn = '<a class="dropdown-item" href="'.route('admin.destination.region.edit',encrypt($row->id)).'"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                endif;
                if($user->can('region-delete')):
                    $deleteBtn = ' <a class="dropdown-item" href="javascript:void(0);" onclick="deleteRegion('.$row->id.')"><i class="bx bx-trash me-1"></i> Delete</a>';
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
            ->rawColumns(['action'])
            ->make(true);
        endif;
        return view('admin.destination.region.index');
    }

    public function regionCreate (){
        if(!Auth::user()->can('region-create')){
            throw UnauthorizedException::forPermissions(['region-create']);
        }
        $countries = Country::latest()->get();
        return view('admin.destination.region.create',compact('countries'));
    }

    public function getStateByCountryId(Request $request) {
        $states = State::where('country_id',$request->input('id'))->get();
        if($states->count() >0):
            return response()->json([
                'status'=>200,
                'msg'=>'State found Successfully !',
                'state'=>$states
            ]);
        else:
            return response()->json([
                'status'=>404,
                'msg'=>'State Not found',
            ]);
        endif;
    }

    public function regionStore(RegionRequest $request) {
        $region = Region::create([
            'country_id' => $request->input('country_name'),
            'state_id' => $request->input('state_name'),
            'name'=>strtolower($request->input('region_name'))
        ]);
        if($region):
            return response()->json([
                'msg'=>"Region Created Successfully, Please Wait redirecting....",
                'url'=>route('admin.destination.region.index')
            ]);
        else:
            return response()->json([
                'msg'=>"Region Not Created , Please Try again!",
            ]);
        endif;
    }

    public function regionEdit($id){
        if(!Auth::user()->can('region-edit')){
            throw UnauthorizedException::forPermissions(['region-edit']);
        }
        $countries = Country::latest()->get();
        $region = Region::findOrFail(decrypt($id));
        $states = State::where('country_id',$region->country_id)->get();
        return view('admin.destination.region.edit',compact('countries','region','states'));

    }

    public function regionUpdate(RegionRequest $request) {
        $region = Region::findOrFail($request->input('id'))->update([
            'country_id' => $request->input('country_name'),
            'state_id' => $request->input('state_name'),
            'name'=>strtolower($request->input('region_name'))
        ]);
        if($region):
            return response()->json([
                'msg'=>"Region Update Successfully, Please Wait redirecting....",
                'url'=>route('admin.destination.region.index')
            ]);
        else:
            return response()->json([
                'msg'=>"Region Not Update , Please Try again!",
            ]);
        endif;
    }

    public function regionDelete(Request $request){
        if(!Auth::user()->can('region-delete')){
            throw UnauthorizedException::forPermissions(['region-delete']);
        }
        $region = Region::findOrFail($request->input('id'))->delete();
        if($region):
            return response()->json([
                'msg'=>"Region Delete Successfully, Please Wait redirecting....",
                'url'=>route('admin.destination.region.index')
            ]);
        else:
            return response()->json([
                'msg'=>"Region Not Delete , Please Try again!",
            ]);
        endif;
    }

    public function cityList(Request $request){
        if(!Auth::user()->can('city-list')){
            throw UnauthorizedException::forPermissions(['city-list']);
        }
        if($request->ajax()):
            $city = City::with('state','country')->latest();
            return DataTables::of($city)
            ->addIndexColumn()
            ->addColumn('country_name',function($row){
                return ucfirst($row->country->name);
            })
            ->addColumn('state_name',function($row){
                return ucfirst($row->state->name);
            })
            ->addColumn('region_name',function($row){
                return ucfirst($row->region->name);
            })
            ->editColumn('name',function($row){
                return ucfirst($row->name);
            })
            ->addColumn('action',function($row){
                $user = Auth::user();
                $editBtn='';
                $deleteBtn='';
                if($user->can('city-edit')):
                    $editBtn = '<a class="dropdown-item" href="'.route('admin.destination.city.edit',encrypt($row->id)).'"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                endif;
                if($user->can('city-delete')):
                    $deleteBtn = ' <a class="dropdown-item" href="javascript:void(0);" onclick="deleteCity('.$row->id.')"><i class="bx bx-trash me-1"></i> Delete</a>';
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
            ->rawColumns(['action'])
            ->make(true);
        endif;
        return view("admin.destination.city.index");
    }


    public function CityCreate() {
        if(!Auth::user()->can('city-create')){
            throw UnauthorizedException::forPermissions(['city-create']);
        }
        $countries = Country::latest()->get();
        return view('admin.destination.city.create',compact('countries'));
    }

    // Get Region By State ID

    public function getRegionByStateId(Request $request) {
        $region = Region::where('state_id',$request->input('id'))->get();
        if($region->count() >0):
            return response()->json([
                'status'=>200,
                'msg'=>'Region found Successfully !',
                'region'=>$region
            ]);
        else:
            return response()->json([
                'status'=>404,
                'msg'=>'Region Not found',
            ]);
        endif;
    }


    public function cityStore(CityRequest $request) {
        $city = City::create([
            'country_id'=>$request->input('country_name'),
            'state_id'=>$request->input('state_name'),
            'region_id'=>$request->input('region_name'),
            'name'=>strtolower($request->input('city_name')),
        ]);

        if($city):
            return response()->json([
                'msg'=>"City Created Successfully, Please Wait redirecting....",
                'url'=>route('admin.destination.city.index')
            ]);
        else:
            return response()->json([
                'msg'=>"City Not Created, Please try again!",
            ]);
        endif;
    } 

    public function cityEdit($id) {
        if(!Auth::user()->can('city-edit')){
            throw UnauthorizedException::forPermissions(['city-edit']);
        }
        $city = City::findOrFail(decrypt($id));
        $countries = Country::latest()->get();
        $states = State::where('country_id',$city->country_id)->get();
        $regions = Region::where('state_id',$city->state_id)->get();
        return view('admin.destination.city.edit',compact('city','countries','states','regions'));
    }

    public function cityUpdate (CityRequest $request) {
        $city = City::findOrFail($request->input('id'))->update([
            'country_id'=>$request->input('country_name'),
            'state_id'=>$request->input('state_name'),
            'region_id'=>$request->input('region_name'),
            'name'=>strtolower($request->input('city_name')),
        ]);

        if($city):
            return response()->json([
                'msg'=>"City Update Successfully, Please Wait redirecting....",
                'url'=>route('admin.destination.city.index')
            ]);
        else:
            return response()->json([
                'msg'=>"City Not Update, Please try again!",
            ]);
        endif;
    }

    public function cityDelete (Request $request) {
        if(!Auth::user()->can('city-delete')){
            throw UnauthorizedException::forPermissions(['city-delete']);
        }
        $city = City::findOrFail($request->input('id'))->delete();
        if($city):
            return response()->json([
                'msg'=>"City Delete Successfully, Please Wait redirecting....",
                'url'=>route('admin.destination.city.index')
            ]);
        else:
            return response()->json([
                'msg'=>"City Not Delete, Please try again!",
            ]);
        endif;
    }

    public function subcityList (Request $request) {
        if(!Auth::user()->can('sub-city-list')){
            throw UnauthorizedException::forPermissions(['sub-city-list']);
        }
        if($request->ajax()):
            $subCity = SubCity::with('state','country')->latest();
            return DataTables::of($subCity)
            ->addIndexColumn()
            ->addColumn('country_name',function($row){
                return ucfirst($row->country->name);
            })
            ->addColumn('state_name',function($row){
                return ucfirst($row->state->name);
            })
            ->addColumn('region_name',function($row){
                return ucfirst($row->region->name);
            })
            ->editColumn('name',function($row){
                return ucfirst($row->name);
            })
            ->addColumn('action',function($row){
                $user = Auth::user();
                $editBtn='';
                $deleteBtn='';
                if($user->can('city-edit')):
                    $editBtn = '<a class="dropdown-item" href="'.route('admin.destination.subcity.edit',encrypt($row->id)).'"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                endif;
                if($user->can('city-delete')):
                    $deleteBtn = ' <a class="dropdown-item" href="javascript:void(0);" onclick="deleteSubCity('.$row->id.')"><i class="bx bx-trash me-1"></i> Delete</a>';
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
            ->rawColumns(['action'])
            ->make(true);
        endif;

        return view('admin.destination.subcity.index');
    }
    
    public function subcityCreate () {
        if(!Auth::user()->can('sub-city-create')){
            throw UnauthorizedException::forPermissions(['sub-city-create']);
        }
        $countries = Country::latest()->get();
        return view('admin.destination.subcity.create',compact('countries'));
    }

    // Get City By region id 
    public function getCityByRegionId(Request $request) {
        $city = City::where('region_id',$request->input('id'))->get();
        if($city->count() >0):
            return response()->json([
                'status'=>200,
                'msg'=>'City found Successfully !',
                'city'=>$city
            ]);
        else:
            return response()->json([
                'status'=>404,
                'msg'=>'City Not found',
            ]);
        endif;
    }

    public function subcityStore(SubCityRequest $request) {
        $subCity = SubCity::create([
            'country_id' => $request->input('country_name'),
            'state_id' => $request->input('state_name'),
            'region_id' => $request->input('region_name'),
            'city_id' => $request->input('city_name'),
            'name' => $request->input('sub_city_name'),
        ]);

        if($subCity):
            return response()->json([
                'msg'=>"Sub City Created Successfully, Please Wait redirecting....",
                'url'=>route('admin.destination.subcity.index')
            ]);
        else:
            return response()->json([
                'msg'=>"Sub City not created , Please try again...."
            ]);
        endif;
    }

    public function subcityEdit($id){
        // dd("test");
        if(!Auth::user()->can('sub-city-edit')){
            throw UnauthorizedException::forPermissions(['sub-city-edit']);
        }
        $subCity = SubCity::findOrFail(decrypt($id));

        $countries = Country::latest()->get();
        $states = State::where('country_id',$subCity->country_id)->get();
        $regions = Region::where('state_id',$subCity->state_id)->get();
        $cities = City::where('region_id',$subCity->region_id)->get();
   
        return view('admin.destination.subcity.edit',compact('subCity','countries','states','regions','cities'));
    }

    public function subcityUpdate(SubCityRequest $request) {
        $subCity = SubCity::findorFail($request->input('id'))->update([
            'country_id' => $request->input('country_name'),
            'state_id' => $request->input('state_name'),
            'region_id' => $request->input('region_name'),
            'city_id' => $request->input('city_name'),
            'name' => $request->input('sub_city_name'),
        ]);

        if($subCity):
            return response()->json([
                'msg'=>"Sub City Update Successfully, Please Wait redirecting....",
                'url'=>route('admin.destination.subcity.index')
            ]);
        else:
            return response()->json([
                'msg'=>"Sub City not Update , Please try again...."
            ]);
        endif;
    }

    public function subcityDelete(Request $request) {
        if(!Auth::user()->can('sub-city-delete')){
            throw UnauthorizedException::forPermissions(['sub-city-edit']);
        }
        $subCity = SubCity::findorFail($request->input('id'))->delete();
        if($subCity):
            return response()->json([
                'msg'=>"Sub City Delete Successfully, Please Wait redirecting....",
                'url'=>route('admin.destination.subcity.index')
            ]);
        else:
            return response()->json([
                'msg'=>"Sub City not Update , Please try again...."
            ]);
        endif;
    }


    public function getSubCityById(Request $request) {
        $subCity= SubCity::where('city_id',$request->input('id'))->get();
        if($subCity->count() >0):
            return response()->json([
                'status'=>200,
                'msg'=>'Sub City found Successfully !',
                'subCity'=>$subCity
            ]);
        else:
            return response()->json([
                'status'=>404,
                'msg'=>'City Not found',
            ]);
        endif;
    }
    
}
