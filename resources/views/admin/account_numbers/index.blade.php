@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Account Numbers (bKash) <a href="{{ route('admin.account-numbers.create') }}" class="btn btn-sm btn-success float-right">New</a></div>
    <div class="card-body">
        <table class="table table-bordered table-sm">
            <thead><tr><th>ID</th><th>Number</th><th>Name</th><th>Type</th><th>Status</th><th>Action</th></tr></thead>
            <tbody>
                @foreach($accounts as $account)
                    <tr>
                        <td>{{ $account->id }}</td>
                        <td>{{ $account->account_number }}</td>
                        <td>{{ $account->account_name }}</td>
                        <td>{{ $account->type }}</td>
                        <td>{{ $account->status ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <a href="{{ route('admin.account-numbers.edit', $account->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form method="POST" action="{{ route('admin.account-numbers.destroy', $account->id) }}" style="display:inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger" onclick="return confirm('Delete this account?')">Delete</button></form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $accounts->links() }}
    </div>
</div>
@endsection
