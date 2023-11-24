@extends('layouts.app')

@section('title', 'Message')

@section('content')
<div class="row gx-5 w-50 mx-auto">
    <h3 class="ps-0">Messages</h3>
    @forelse($messages as $message)
        <div class="row align-items-center mb-2 bg-white shadow-sm rounded-3 py-3">
            @if ($message->fromUser->id === Auth::user()->id)
            <div class="col-md-auto">
                <a href="{{ route('message.show', $message->toUser->id) }}">
                    @if ($message->toUser->avatar)
                        <img src="{{ $message->toUser->avatar }}" alt="{{ $message->toUser->name }}" class="rounded-circle avatar-md">
                    @else
                        <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                    @endif
                </a>
            </div>
            <div class="col-md ps-0">
                <div class="row">
                    <div class="col-auto">
                        <a href="{{ route('message.show', $message->toUser->id) }}" class="text-decoration-none text-secondary text-dark fw-bold">{{ $message->toUser->name }}</a>
                    </div>
                    <div class="col text-end">
                        <small>{{ date('H:i', strtotime($message->created_at)) }}</small>
                    </div>
                </div>

                <p>{{ $message->message }}</p>
            </div>
            @else
            <div class="col-md-auto">
                <a href="{{ route('message.show', $message->fromUser->id) }}">
                    @if ($message->fromUser->avatar)
                        <img src="{{ $message->fromUser->avatar }}" alt="{{ $message->fromUser->name }}" class="rounded-circle avatar-md">
                    @else
                        <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                    @endif
                </a>
            </div>
            <div class="col-md ps-0">
                <div class="row">
                    <div class="col-auto">
                        <a href="{{ route('message.show', $message->fromUser->id) }}" class="text-decoration-none text-secondary text-dark fw-bold">{{ $message->fromUser->name }}</a>
                    </div>
                    <div class="col text-end">
                        <small>{{ date('H:i', strtotime($message->created_at)) }}</small>
                    </div>
                </div>

                <p>{{ $message->message }}</p>
            </div>
            @endif

        </div>
    @empty

        <div>No messages yet.</div>

    @endforelse
</div>

@endsection
