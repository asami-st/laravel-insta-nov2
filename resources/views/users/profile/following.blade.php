@extends('layouts.app')

@section('title', 'Followings')

@section('content')
    {{-- Include the header.blade.php --}}
    @include('users.profile.header')

    <div class="container w-50 mx-auto mt-5">
        @if ($following_users->isNotEmpty())
            <h3 class="text-secondary text-center mb-3">Following</h3>
            @foreach ($following_users as $following)
            <div class="row mb-3">
                <div class="col-6 offset-2">
                    <div class="row">
                        <div class="col-auto">
                            <a href="{{ route('profile.show', $following->following_id) }}">
                                @if ($following->following->avatar)
                                    <img src="{{ $following->following->avatar }}" alt="{{ $following->following->name }}" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>

                        </div>
                        <div class="col ps-0">
                            <a href="{{ route('profile.show', $following->following_id) }}" class="text-decoration-none text-dark fw-bold">{{ $following->following->name }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    @if ($following->following->isFollowed())
                        <form action="{{ route('follow.destroy', $following->following_id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item text-danger">UnFollow</button>
                        </form>
                    @else
                        <form action="{{ route('follow.store', $following->following_id) }}" method="post">
                            @csrf
                        <button type="submit" class="dropdown-item text-primary">Follow</button>
                        </form>
                    @endif
                </div>
            </div>
            @endforeach
        @else
            <h3 class="text-muted text-center">No Following Yet</h3>
        @endif

    </div>
@endsection
