@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">New Account Number</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.account-numbers.store') }}">@csrf
            <div class="form-group"><label>Account Number</label><input type="text" name="account_number" class="form-control"></div>
            <div class="form-group"><label>Account Name</label><input type="text" name="account_name" class="form-control"></div>
            <div class="form-group"><label>Type</label><input type="text" name="type" class="form-control"></div>
            <div class="form-group"><label>Note</label><textarea name="note" class="form-control"></textarea></div>
            <div class="form-group"><label>Status</label><input type="checkbox" name="status" checked></div>
            <button class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
@endsection
