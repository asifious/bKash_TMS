@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">Edit Account Number</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.account-numbers.update', $account->id) }}">@csrf @method('PUT')
            <div class="form-group"><label>Account Number</label><input type="text" name="account_number" class="form-control" value="{{ $account->account_number }}"></div>
            <div class="form-group"><label>Account Name</label><input type="text" name="account_name" class="form-control" value="{{ $account->account_name }}"></div>
            <div class="form-group"><label>Type</label><input type="text" name="type" class="form-control" value="{{ $account->type }}"></div>
            <div class="form-group"><label>Note</label><textarea name="note" class="form-control">{{ $account->note }}</textarea></div>
            <div class="form-group"><label>Status</label><input type="checkbox" name="status" {{ $account->status ? 'checked' : '' }}></div>
            <button class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
