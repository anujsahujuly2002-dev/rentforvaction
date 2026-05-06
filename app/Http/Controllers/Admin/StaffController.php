<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use Spatie\Permission\Models\Role;
use App\Http\Requests\Admin\Staff\StaffRequest;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Hash;
use DB;
use Auth;

class StaffController extends Controller
{
    public function index (Request $request) {
        if(!Auth::user()->can('user-list')){
            throw UnauthorizedException::forPermissions(['user-list']);
        }
        if($request->ajax()):
            $staff = User::whereHas('roles',function($q){
                    $q->whereNotIn('name',['super-admin','owner']);
                });
            return DataTables::of($staff)
            ->addIndexColumn()
            ->addColumn('role',function($row){
                return strlen($row->roles['0']->name)<=3?strtoupper($row->roles['0']->name):ucfirst($row->roles['0']->name);
            })
            ->addColumn('action',function($row){
                $user = Auth::user();
                $editBtn='';
                $deleteBtn='';
                if($user->can('user-edit')):
                    $editBtn = '<a class="dropdown-item" href="'.route('admin.staff.edit',encrypt($row->id)).'"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                endif;
                if($user->can('user-delete')):
                    $deleteBtn = '<a class="dropdown-item" href="javascript:void(0);" onclick="deleteStaff('.$row->id.')"><i class="bx bx-trash me-1"></i> Delete</a>';
                endif;

                return '<div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
                  '.$editBtn.$deleteBtn.'
                </div>
              </div>';
            })
            ->rawColumns(['role','action'])
            ->make(true);
        endif;
        return view('admin.staff.index'); 
    }

    public function create() {
        if(!Auth::user()->can('user-create')){
            throw UnauthorizedException::forPermissions(['user-list']);
        }
        $roles = Role::whereNot('id','1')->get();
        return view('admin.staff.create',compact('roles'));
    }

    public function store(StaffRequest $request){
       $staff = User::create([
            'name'=>strtolower($request->input('name')),
            'email'=>$request->input('email'),
            'password'=>Hash::make("Hrbo@123#")
       ]);
       $staff->assignRole($request->input('role'));
       if($staff):
            return response()->json([
                'msg'=>"Staff Created Successfully,Please Wait Redirecting...",
                'url'=>route('admin.staff.list')
            ]);
       else:
        return response()->json([
            'msg'=>"Staff Not Created,Please try again !",
        ]);
       endif;
    }

    public function edit($id){
        if(!Auth::user()->can('user-edit')){
            throw UnauthorizedException::forPermissions(['user-edit']);
        }
        $staff = User::findOrFail(decrypt($id));
        $roles = Role::whereNot('id','1')->get();
        return view('admin.staff.edit',compact('staff','roles'));
    }

    public function update(StaffRequest $request) {
        $staff = $staff = User::where('id',$request->input('id'))->update([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            // 'password'=>Hash::make("Hrbo@123#")
        ]);
        DB::table('model_has_roles')->where('model_id',$request->input('id'))->delete();
        User::findOrFail($request->input('id'))->assignRole($request->input('role'));
        if($staff):
            return response()->json([
                'msg'=>"Staff Updated Successfully,Please Wait Redirecting...",
                'url'=>route('admin.staff.list')
            ]);
       else:
        return response()->json([
            'msg'=>"Staff Not Updated,Please try again !",
        ]);
       endif;
    }

    public function delete(Request $request) {
        if(!Auth::user()->can('user-delete')){
            throw UnauthorizedException::forPermissions(['user-delete']);
        }
        $staff = User::findOrFail($request->input('id'))->delete();
        if($staff):
            return response()->json([
                'msg'=>"Staff Delete Successfully,Please Wait Redirecting...",
                'url'=>route('admin.staff.list')
            ]);
       else:
        return response()->json([
            'msg'=>"Staff Not Delete,Please try again !",
        ]);
       endif;
    }
}
