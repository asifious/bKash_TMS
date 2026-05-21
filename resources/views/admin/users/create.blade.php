@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Create User</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="form-group"><label>Name</label><input type="text" name="name" class="form-control"></div>
            <div class="form-group"><label>Username</label><input type="text" name="username" class="form-control"></div>
            <div class="form-group"><label>Password</label><input type="password" name="password" class="form-control"></div>
            <div class="form-group"><label>Role</label><select name="role" class="form-control"><option value="user">User</option><option value="admin">Admin</option></select></div>
            <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control"></div>
            <div class="form-group"><label>Phone</label><input type="text" name="phone" class="form-control"></div>
            <div class="form-group"><label>Status</label><input type="checkbox" name="status" checked></div>
            <button class="btn btn-primary">Create</button>
        </form>
    </div>
</div>
@endsection
