@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Edit User</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.update',$user->id) }}">@csrf @method('PUT')
            <div class="form-group"><label>Name</label><input type="text" name="name" class="form-control" value="{{ $user->name }}"></div>
            <div class="form-group"><label>Username</label><input type="text" name="username" class="form-control" value="{{ $user->username }}"></div>
            <div class="form-group"><label>New Password (leave blank to keep)</label><input type="password" name="password" class="form-control"></div>
            <div class="form-group"><label>Role</label><select name="role" class="form-control"><option {{ $user->role=='user'?'selected':'' }} value="user">User</option><option {{ $user->role=='admin'?'selected':'' }} value="admin">Admin</option></select></div>
            <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control" value="{{ $user->email }}"></div>
            <div class="form-group"><label>Phone</label><input type="text" name="phone" class="form-control" value="{{ $user->phone }}"></div>
            <div class="form-group"><label>Status</label><input type="checkbox" name="status" {{ $user->status ? 'checked' : '' }}></div>
            <button class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
