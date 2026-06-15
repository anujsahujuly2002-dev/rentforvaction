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
    public function index(Request $request)
    {
        if (!Auth::user()->can('owner-list')) {
            throw UnauthorizedException::forPermissions(['owner-list']);
        }

        if ($request->ajax()) {
            $owner = User::whereHas('roles', function ($q) {
                $q->where('name', 'owner');
            });

            return DataTables::of($owner)
                ->addIndexColumn()
                ->editColumn('is_approved', function ($row) {
                    if ($row->is_approved == 1) {
                        return '<span class="badge bg-success">Approved</span>';
                    }
                    return '<span class="badge bg-warning text-dark">Pending</span>';
                })
                ->addColumn('total_properties', function ($row) {
                    return '<span class="badge bg-info">' . $row->properties()->count() . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $approveLabel = $row->is_approved == 1 ? 'Revoke Approval' : 'Approve';
                    $approveIcon  = $row->is_approved == 1 ? 'bx-x-circle' : 'bx-check-circle';
                    $approveColor = $row->is_approved == 1 ? 'text-danger' : 'text-success';

                    return '
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item toggle-approve-owner ' . $approveColor . '"
                                   href="javascript:void(0);"
                                   data-id="' . $row->id . '"
                                   data-approved="' . $row->is_approved . '"
                                   data-name="' . e($row->name) . '">
                                    <i class="bx ' . $approveIcon . ' me-1"></i>' . $approveLabel . '
                                </a>
                                <a class="dropdown-item text-danger delete-owner"
                                   href="javascript:void(0);"
                                   data-id="' . $row->id . '"
                                   data-name="' . e($row->name) . '">
                                    <i class="bx bx-trash me-1"></i>Delete
                                </a>
                            </div>
                        </div>';
                })
                ->rawColumns(['is_approved', 'total_properties', 'action'])
                ->make(true);
        }

        return view('admin.owner.index');
    }

    public function toggleApprove(Request $request)
    {
        if (!Auth::user()->can('owner-list')) {
            throw UnauthorizedException::forPermissions(['owner-list']);
        }

        $user = User::whereHas('roles', fn($q) => $q->where('name', 'owner'))
            ->findOrFail($request->input('id'));

        $newValue = $user->is_approved == 1 ? 0 : 1;
        $user->update(['is_approved' => $newValue]);

        $msg = $newValue == 1 ? 'Owner approved successfully.' : 'Owner approval revoked.';

        return response()->json(['status' => 200, 'msg' => $msg]);
    }

    public function destroy(Request $request)
    {
        if (!Auth::user()->can('owner-list')) {
            throw UnauthorizedException::forPermissions(['owner-list']);
        }

        $user = User::whereHas('roles', fn($q) => $q->where('name', 'owner'))
            ->findOrFail($request->input('id'));

        if ($user->properties()->count() > 0) {
            return response()->json(['status' => 422, 'msg' => "Can't delete this account. Owner has active properties."]);
        }

        $user->forceDelete();

        return response()->json(['status' => 200, 'msg' => 'Owner deleted successfully.']);
    }
}
