<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Yajra\DataTables\Facades\DataTables;

class OwnerController extends Controller
{
    public function index(Request $request){
         if(!Auth::user()->can('owner-list')){
            throw UnauthorizedException::forPermissions(['user-list']);
        }
        if($request->ajax()):
            $owner = User::whereHas('roles',function($q){
                $q->where('name','owner');
            });
            return DataTables::of($owner)
            ->addIndexColumn()
            ->editColumn('type',function($row){
                if($row->type==="1"):
                    return '<span class="badge bg-primary">Admin</span>';
                elseif($row->type=="0"):
                    return '<span class="badge bg-success">Owner</span>';
                endif;
                return '<span class="badge bg-secondary">Unknown</span>';
            })
            ->addColumn('total_properties',function($row){
                return '<span class="badge bg-info">'.$row->properties()->count().'</span>';
             })
            ->addColumn('action',function($row){
                return '<div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>Block</a>
                </div>
              </div>';
            })
            ->rawColumns(['type', 'total_properties', 'action'])
            ->make(true);
        endif;
        return view('admin.owner.index');
    }
}
