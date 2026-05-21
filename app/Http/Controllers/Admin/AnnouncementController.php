<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::orderBy('created_at','desc')->paginate(20);
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'message' => 'required',
            'status' => 'required|boolean',
            'expire_at' => 'nullable|date',
        ]);

        Announcement::create([
            'title' => $request->title,
            'message' => $request->message,
            'status' => $request->status,
            'expire_at' => $request->expire_at,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.announcements.index')->with('success','Announcement created');
    }

    public function edit($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);
        $request->validate([
            'title' => 'required',
            'message' => 'required',
            'status' => 'required|boolean',
            'expire_at' => 'nullable|date',
        ]);

        $announcement->update($request->only(['title','message','status','expire_at']));

        return redirect()->route('admin.announcements.index')->with('success','Announcement updated');
    }

    public function destroy($id)
    {
        Announcement::findOrFail($id)->delete();
        return redirect()->route('admin.announcements.index')->with('success','Announcement deleted');
    }
}
