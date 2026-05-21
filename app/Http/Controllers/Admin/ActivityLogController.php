<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\User;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::query();

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->action) {
            $query->where('action', 'like', '%'.$request->action.'%');
        }
        if ($request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $logs = $query->orderBy('created_at','desc')->paginate(20);
        $users = User::orderBy('name')->get();

        return view('admin.activity_logs.index', compact('logs','users'));
    }
}
