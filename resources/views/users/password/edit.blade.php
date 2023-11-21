@extends('layouts.app')

@section('title' , 'Change Password')

@section('content')
<div class="row justify-content-center">
    <div class="col-5">
        <form action="{{ route('password.update') }}" method="post" class="bg-white shadow rounded-3 p-5">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <h2 class="h3 fw-light text-muted">Change Password</h2>
                <span class="">{{$user->name}}</span>
            </div>
            <div class="mb-3">
                <label for="current-password" class="form-label text-muted">Current Password</label>
                <input type="password" name="password" class="form-control" id="current-password">
            </div>
            <div class="mb-3">
                <label for="new-password" class="form-label text-muted">New Password</label>
                <input type="password" name="new_password" id="new-password" class="form-control" placeholder="At least 8 characters">
            </div>
            <div class="mb-4">
                <label for="confirm-password" class="form-label text-muted">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm-password" class="form-control" placeholder="At least 8 characters">
            </div>


            <button type="submit" class="btn btn-primary w-100 px-5">Change Password</button>
        </form>
    </div>
</div>
@endsection
