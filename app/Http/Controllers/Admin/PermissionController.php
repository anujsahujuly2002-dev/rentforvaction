<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Spatie\Permission\Models\Permission;
use Auth;
use App\Http\Requests\Admin\Permission\PermissionRequest;
use Spatie\Permission\Exceptions\UnauthorizedException;

class PermissionController extends Controller
{
    public function index(Request $request){
        if(!Auth::user()->can('permission-list')){
            throw UnauthorizedException::forPermissions(['permission-list']);
        }
        if($request->ajax()):
            $permission = Permission::latest()->get();
            return DataTables::of($permission)
            ->addIndexColumn()
            ->addColumn('action', function($row){
				$user = Auth::user();
                $editBtn='';
                $deleteBtn='';
                if($user->can('permission-edit')):
                    $editBtn = '<a class="dropdown-item" href="'.route('admin.permission.edit',encrypt($row->id)).'"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                endif;
                if($user->can('permission-delete')):
                    $deleteBtn = ' <a class="dropdown-item" href="javascript:void(0);" onclick="deletePermission('.$row->id.')"><i class="bx bx-trash me-1"></i> Delete</a>';
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
        return view('admin.permission.index');
    }

	public function create() {
		if(!Auth::user()->can('permission-create')){
            throw UnauthorizedException::forPermissions(['permission-create']);
        }
		return view('admin.permission.create');
	}
	
	// Permission Store 
	public function store(PermissionRequest $request) {
		// dd($request->all());
		$permission=Permission::create([
			'name'=>strtolower(str_replace(' ','-',$request->input('permission_name'))),
			'group'=>strtolower($request->input('permission_group')),
		]);
		if($permission):
			return response()->json([
				'msg'=>"Permission Created Successfully. Please wait Redirecting ..!",
				'url'=>route("admin.permission.list")
			]);
		else:
			return response()->json([
				'msg'=>"Permission Not Created. Please wait try again ..!",
			]);
		endif;
	}

	public function edit($id) {
		if(!Auth::user()->can('permission-edit')){
            throw UnauthorizedException::forPermissions(['permission-edit']);
        }
		$permission = Permission::findOrFail(decrypt($id));
		return view("admin.permission.edit",compact('permission'));

	}

	// Permission Store 
	public function update(PermissionRequest $request) {
		$permission=Permission::where('id',$request->input('id'))->update([
			'name'=>strtolower(str_replace(' ','-',$request->input('permission_name'))),
			'group'=>strtolower($request->input('permission_group')),
		]);
		if($permission):
			return response()->json([
				'msg'=>"Permission Updated Successfully. Please wait Redirecting ..!",
				'url'=>route("admin.permission.list")
			]);
		else:
			return response()->json([
				'msg'=>"Permission Not Updated. Please wait try again ..!",
			]);
		endif;
	}

	public function delete(Request $request){
		if(!Auth::user()->can('permission-delete')){
            throw UnauthorizedException::forPermissions(['permission-delete']);
        }
		$permission = Permission::findOrFail($request->input('id'))->delete();
		if($permission):
			return response()->json([
				'msg'=>"Permission Deleted Successfully. Please wait Redirecting ..!",
				'url'=>route("admin.permission.list")
			]);
		else:
			return response()->json([
				'msg'=>"Permission Not Delete. Please wait try again ..!",
			]);
		endif;
	}
}
