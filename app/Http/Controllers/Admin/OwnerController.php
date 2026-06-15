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
                ->editColumn('status', function ($row) {
                    if ($row->status == 1) {
                        return '<span class="badge bg-danger">Blocked</span>';
                    }
                    return '<span class="badge bg-success">Active</span>';
                })
                ->addColumn('total_properties', function ($row) {
                    return '<span class="badge bg-info">' . $row->properties()->count() . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $approveBtn = '';
                    if ($row->is_approved != 1) {
                        $approveBtn = '<a class="dropdown-item approve-owner" href="javascript:void(0);" data-id="' . $row->id . '"><i class="bx bx-check me-1"></i>Approve</a>';
                    }
                    $blockLabel = $row->status == 1 ? 'Unblock' : 'Block';
                    $blockIcon  = $row->status == 1 ? 'bx-lock-open' : 'bx-block';
                    $blockBtn   = '<a class="dropdown-item toggle-block-owner" href="javascript:void(0);" data-id="' . $row->id . '" data-status="' . $row->status . '"><i class="bx ' . $blockIcon . ' me-1"></i>' . $blockLabel . '</a>';

                    return '<div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                          <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">' . $approveBtn . $blockBtn . '</div>
                      </div>';
                })
                ->rawColumns(['is_approved', 'status', 'total_properties', 'action'])
                ->make(true);
        }

        return view('admin.owner.index');
    }

    public function approve(Request $request)
    {
        if (!Auth::user()->can('owner-list')) {
            throw UnauthorizedException::forPermissions(['owner-list']);
        }

        $user = User::whereHas('roles', fn($q) => $q->where('name', 'owner'))
            ->findOrFail($request->input('id'));

        $user->update(['is_approved' => 1]);

        return response()->json(['status' => 200, 'msg' => 'Owner approved successfully.']);
    }

    public function toggleBlock(Request $request)
    {
        if (!Auth::user()->can('owner-list')) {
            throw UnauthorizedException::forPermissions(['owner-list']);
        }

        $user = User::whereHas('roles', fn($q) => $q->where('name', 'owner'))
            ->findOrFail($request->input('id'));

        $newStatus = $user->status == 1 ? 0 : 1;
        $user->update(['status' => $newStatus]);

        $msg = $newStatus == 1 ? 'Owner blocked.' : 'Owner unblocked.';

        return response()->json(['status' => 200, 'msg' => $msg]);
    }
}
