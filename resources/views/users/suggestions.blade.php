@extends('layouts.app')

@section('title', 'Suggestions')

@section('content')
<div class="container w-50 mx-auto mt-3">
    <div class="row">
        <h3 class="mb-4 text-muted">Suggestions for you</h3>
        @foreach ($all_suggested_users as $user)
            <div class="col-8">
                <div class="row mb-2">
                    <div class="col-auto">
                        <a href="{{ route('profile.show', $user->id) }}">
                            @if ($user->avatar)
                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle avatar-sm">
                            @else
                                <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                            @endif
                        </a>

                    </div>
                    <div class="col">
                        <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $user->name }}</a>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <form action="{{ route('follow.store', $user->id) }}" method="post">
                    @csrf
                <button type="submit" class="dropdown-item text-primary">Follow</button>
                </form>
            </div>

        @endforeach
    </div>
    <div class="d-flex justify-content-center">
        {{ $all_suggested_users->links() }}
    </div>
</div>
@endsection
