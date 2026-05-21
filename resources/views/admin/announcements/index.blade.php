@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">Announcements for Users <a href="{{ route('admin.announcements.create') }}" class="btn btn-sm btn-success float-right">New</a></div>
    <div class="card-body">
        <table class="table table-sm table-bordered">
            <thead><tr><th>ID</th><th>Title</th><th>Status</th><th>Expires</th><th>Action</th></tr></thead>
            <tbody>
                @foreach($announcements as $announcement)
                    <tr>
                        <td>{{ $announcement->id }}</td>
                        <td>{{ $announcement->title }}</td>
                        <td>{{ $announcement->status ? 'Active' : 'Inactive' }}</td>
                        <td>{{ $announcement->expire_at }}</td>
                        <td>
                            <a href="{{ route('admin.announcements.edit',$announcement->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form method="POST" action="{{ route('admin.announcements.destroy', $announcement->id) }}" style="display:inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger" onclick="return confirm('Delete announcement?')">Delete</button></form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $announcements->links() }}
    </div>
</div>
@endsection
