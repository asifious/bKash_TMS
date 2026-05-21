@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Users <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-success float-right">New</a></div>
    <div class="card-body">
        <table class="table table-sm table-bordered">
            <thead><tr><th>ID</th><th>Name</th><th>Username</th><th>Role</th><th>Status</th><th>Action</th></tr></thead>
            <tbody>
                @foreach($users as $u)
                    <tr>
                        <td>{{ $u->id }}</td>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->username }}</td>
                        <td>{{ $u->role }}</td>
                        <td>{{ $u->status ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit',$u->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form method="POST" action="{{ route('admin.users.destroy',$u->id) }}" style="display:inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button></form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
</div>
@endsection
