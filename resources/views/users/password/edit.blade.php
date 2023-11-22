@extends('layouts.app')

@section('title' , 'Change Password')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-5 col-md-6 col-sm-auto">
        <form action="{{ route('password.update', Auth::user()->id) }}" method="post" class="bg-white shadow rounded-3 p-5">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <h2 class="h3 fw-light text-muted">Change Password</h2>
                <span class="text-muted"><i class="fa-solid fa-user"></i> {{Auth::user()->name}}</span>
            </div>
            <div class="mb-3">
                <label for="current-password" class="form-label text-muted">Current Password</label>
                <input type="password" name="current_password" class="form-control" id="current-password">
                @if(session('warning'))
                    <div class="text-danger">
                        {{ session('warning') }}
                    </div>
                @endif
            </div>
            <div class="mb-3">
                <label for="new-password" class="form-label text-muted">New Password</label>
                <input type="password" name="new_password" id="new-password" class="form-control" placeholder="At least 8 characters">
            </div>
            <div class="mb-4">
                <label for="password-confirmation" class="form-label text-muted">Confirm Password</label>
                <input type="password" name="new_password_confirmation" id="password-confirmation" class="form-control" placeholder="At least 8 characters">
                @error('new_password')
                    <p class="text-danger small">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary w-100 px-5">Change Password</button>
        </form>
    </div>
</div>
@endsection
