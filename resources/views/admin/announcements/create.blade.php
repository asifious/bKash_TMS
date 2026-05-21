@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">New Announcement for Users</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.announcements.store') }}">@csrf
            <div class="form-group"><label>Title</label><input type="text" name="title" class="form-control"></div>
            <div class="form-group"><label>Message</label><textarea name="message" class="form-control"></textarea></div>
            <div class="form-group"><label>Expires At</label><input type="datetime-local" name="expire_at" class="form-control"></div>
            <div class="form-group"><label>Status</label><select name="status" class="form-control"><option value="1">Active</option><option value="0">Inactive</option></select></div>
            <button class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
@endsection
