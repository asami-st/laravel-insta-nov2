@extends('layouts.app')

@section('title', 'Message')

@section('content')

<div class="card w-50 mx-auto" style="height: 70vh">
    <div class="card-header bg-white py-3">
        <div class="row align-items-center">
            <div class="col-auto">
                <a href="{{ route('profile.show', $user->id) }}">
                    @if ($user->avatar)
                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle avatar-sm">
                    @else
                        <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                    @endif
                </a>
            </div>
            <div class="col ps-0">
                <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark">{{ $user->name }}</a>
            </div>
        </div>
    </div>
    <div class="card-body" style="overflow-y: auto;">
        @forelse($messages as $message)
            @if ($message->send_user_id === Auth::user()->id)
                <div class="row text-end gx-1">
                    <div class="col">
                        <p class="text-muted small pt-3">{{ $message->created_at->format('H:i') }}</p>
                    </div>
                    <div class="col-auto">
                        <p class="bg-primary text-white rounded-pill py-2 px-3">{{ $message->message }}</p>
                    </div>
                </div>
            @else
                <div class="row gx-1">
                    <div class="col-auto">
                        <p class="bg-white border border-secondary rounded-pill py-2 px-3">{{ $message->message }}</p>
                    </div>
                    <div class="col">
                        <p class="text-muted small pt-3">{{ $message->created_at->format('H:i') }}</p>
                    </div>
                </div>
            @endif

        @empty

            <div>No messages yet.</div>

        @endforelse

    </div>
    <div class="card-footer bg-light">
        <form action="{{ route('message.send', $user->id) }}" method="post">
            @csrf
            <div class="row gx-1">
                <div class="col-md-9 offset-1">
                    <input type="text" name="message" id="message" class="form-control bg-white">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-outline-secondary">
                        <i class="fa-regular fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection
