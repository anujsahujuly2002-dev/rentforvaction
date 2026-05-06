<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Auth;
use DataTables;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Admin\Role\RoleRequest;
use DB;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RoleController extends Controller
{
    public function index (Request $request){
        if(!Auth::user()->can('role-list')){
            throw UnauthorizedException::forPermissions(['role-list']);
        }
        if($request->ajax()):
            $role = Role::latest()->get();
            return DataTables::of($role)
            ->addIndexColumn()
            ->editColumn('name',function($row){
                return ucfirst(str_replace('-',' ',$row->name));
            })
            ->addColumn('permission',function($row){
                $assignPermissions = $row->permissions;
                $permssions = '';
                foreach($assignPermissions as $permission):
                    $permssions .='<span class="badge bg-label-secondary">'.ucfirst(strtolower(str_replace('-',' ',$permission->name))).'</span><br>';
                endforeach;
                return $permssions;
            })
            ->addColumn('action', function($row){
                $user = Auth::user();
                $editBtn='';
                $deleteBtn='';
                if($user->can('role-edit')):
                    $editBtn = '<a class="dropdown-item" href="'.route('admin.role.edit',encrypt($row->id)).'"><i class="bx bx-edit-alt me-1"></i> Edit</a>';
                endif;
                if($user->can('role-delete')):
                    $deleteBtn = '<a class="dropdown-item" href="javascript:void(0);" onclick="deleteRole('.$row->id.')"><i class="bx bx-trash me-1"></i> Delete</a>';
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
            ->rawColumns(['action','permission'])
            ->make(true);
        endif;
        return view('admin.role.index');
    }

    public function create(){
        if(!Auth::user()->can('role-create')){
            throw UnauthorizedException::forPermissions(['role-create']);
        }
        $permission = [];
        $groups = Permission::select('group')->distinct()->get()->pluck('group');
        foreach($groups as $group) {
            $permission[$group] = Permission::where('group', $group)->get();
        }
        return view('admin.role.create',compact('permission'));
    }

    public function store(RoleRequest $request) {
       $role = Role::create([
        'name' => strtolower($request->input('role_name'))
       ]);
       $role->givePermissionTo($request->input('permission_id'));
        if($role):
            return response()->json([
                'msg'=>"Role Created Successfully, Please Wait Redirecting ....",
                'url'=>route('admin.role.list')
            ]);
        else:
            return response()->json([
                'msg' => "Role Not created,Please try again..!"
            ]);
        endif;
    }

    public function edit($id){
        if(!Auth::user()->can('role-edit')){
            throw UnauthorizedException::forPermissions(['role-edit']);
        }
        $role = Role::findOrFail(decrypt($id));
        $permission = [];
        $groups = Permission::select('group')->distinct()->get()->pluck('group');
        foreach($groups as $group) {
            $permission[$group] = Permission::where('group', $group)->get();
        }
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", decrypt($id))
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        return view('admin.role.edit',compact('role','rolePermissions','permission'));
    }

    public function update(RoleRequest $request){
        $role = Role::findOrFail($request->input('id'))->update([
            'name' => strtolower($request->input('role_name'))
           ]);
        //    dd($request->input('permission_id'));
        Role::findOrFail($request->input('id'))->syncPermissions($request->input('permission_id'));
        if($role):
            return response()->json([
                'msg'=>"Role Updated Successfully, Please Wait Redirecting ....",
                'url'=>route('admin.role.list')
            ]);
        else:
            return response()->json([
                'msg' => "Role Not Updated,Please try again..!"
            ]);
        endif;
    }

    public function delete(Request $request){
        $role = Role::findOrFail($request->input('id'))->delete();
        if($role):
            return response()->json([
                'msg'=>"Role Deleted Successfully, Please Wait Redirecting ....",
                'url'=>route('admin.role.list')
            ]);
        else:
            return response()->json([
                'msg' => "Role Not Deleted,Please try again..!"
            ]);
        endif;
    }
}
