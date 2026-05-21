@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">Edit Announcement</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.announcements.update', $announcement->id) }}">@csrf @method('PUT')
            <div class="form-group"><label>Title</label><input type="text" name="title" class="form-control" value="{{ $announcement->title }}"></div>
            <div class="form-group"><label>Message</label><textarea name="message" class="form-control">{{ $announcement->message }}</textarea></div>
            <div class="form-group"><label>Expires At</label><input type="datetime-local" name="expire_at" class="form-control" value="{{ optional($announcement->expire_at)->format('Y-m-d\TH:i') }}"></div>
            <div class="form-group"><label>Status</label><select name="status" class="form-control"><option value="1" {{ $announcement->status ? 'selected' : '' }}>Active</option><option value="0" {{ !$announcement->status ? 'selected' : '' }}>Inactive</option></select></div>
            <button class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
