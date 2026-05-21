@extends('layouts.app')

@section('pageTitle', 'My Profile')

@section('content')
<div class="profile-layout">
    <section class="profile-summary-card">
        <div class="profile-avatar">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</div>
        <div>
            <p class="profile-role">{{ ucfirst($user->role) }} account</p>
            <h2>{{ $user->name }}</h2>
            <p class="profile-muted">{{ $user->email ?: 'No email added' }}</p>
        </div>

        <div class="profile-meta">
            <div>
                <span>Username</span>
                <strong>{{ $user->username }}</strong>
            </div>
            <div>
                <span>Phone</span>
                <strong>{{ $user->phone ?: 'Not added' }}</strong>
            </div>
            <div>
                <span>Status</span>
                <strong>{{ $user->status ? 'Active' : 'Inactive' }}</strong>
            </div>
            <div>
                <span>Last Login</span>
                <strong>{{ $user->last_login_at ?: 'Not recorded' }}</strong>
            </div>
        </div>
    </section>

    <section class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Profile</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('profile.update') }}" class="profile-form">
                @csrf
                @method('PATCH')

                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input id="name" type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input id="username" type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input id="phone" type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                    </div>
                </div>

                <div class="profile-divider"></div>

                <h4 class="section-title">Change Password</h4>
                <p class="profile-muted">Leave these fields blank if you want to keep your current password.</p>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input id="current_password" type="password" name="current_password" class="form-control" autocomplete="current-password">
                    </div>

                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input id="password" type="password" name="password" class="form-control" autocomplete="new-password">
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
                    </div>
                </div>

                <div class="profile-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save" aria-hidden="true"></i>
                        <span>Update Profile</span>
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
