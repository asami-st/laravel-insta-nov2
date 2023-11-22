@extends('layouts.app')

@section('title', 'Followers')

@section('content')
    {{-- Include the header.blade.php --}}
    @include('users.profile.header')
    <div class="container w-50 mx-auto mt-5">
        @if ($followers->isNotEmpty())
            <h3 class="text-secondary text-center mb-3">Followers</h3>
            @foreach ($followers as $follower)
            <div class="row mb-3">
                <div class="col-6 offset-2">
                    <div class="row">
                        <div class="col-auto">
                            <a href="{{ route('profile.show', $follower->follower_id) }}">
                                @if ($follower->follower->avatar)
                                    <img src="{{ $follower->follower->avatar }}" alt="{{ $follower->follower->name }}" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>

                        </div>
                        <div class="col ps-0">
                            <a href="{{ route('profile.show', $follower->follower_id) }}" class="text-decoration-none text-dark fw-bold">{{ $follower->follower->name }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    @if ($follower->follower->isFollowed())
                        <form action="{{ route('follow.destroy', $follower->follower_id) }}" method="post">
                            @csrf
                            @method('DELETE')
                        <button type="submit" class="dropdown-item text-secondary">Following</button>
                        </form>
                    @else
                        <form action="{{ route('follow.store', $follower->follower_id) }}" method="post">
                            @csrf
                        <button type="submit" class="dropdown-item text-primary">Follow</button>
                        </form>
                    @endif
                </div>
            </div>
            @endforeach
        @else
            <h3 class="text-muted text-center">No Follower Yet</h3>
        @endif

    </div>



@endsection
