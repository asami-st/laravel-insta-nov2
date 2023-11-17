@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="row gx-5">
        <div class="col-8 bg-light">
            @forelse ($home_posts as $post)
                <div class="card mb-4">
                    {{-- title.blade.php --}}
                    @include('users.posts.contents.title')
                    {{-- body.blade.php --}}
                    @include('users.posts.contents.body')
                </div>
            @empty
                {{-- If the site does not have any post yet, then display this... --}}
                <div class="text-center">
                    <h2>Share Photos</h2>
                    <p class="text-muted">When you share photos, they'll appear on your Profile</p>
                    <a href="{{ route('post.create') }}" class="text-decoration-none">Share your first photo</a>
                </div>
            @endforelse
        </div>
        <div class="col-4 bg-light">
            {{-- Profile Overview --}}
            <div class="row align-items-center mb-5 bg-white shadow-sm rounded-3 py-3">
                <div class="col-auto">
                    <a href="{{ route('profile.show', Auth::user()->id) }}">
                        @if (Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="rounded-circle avatar-md">
                        @else
                            <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                        @endif
                    </a>
                </div>
                <div class="col ps-0">
                    <a href="{{ route('profile.show', Auth::user()->id) }}" class="text-decoration-none text-secondary text-dark fw-bold">{{ Auth::user()->name }}</a>
                    <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                </div>
            </div>

            {{-- Suggestions --}}
            <div class="row">
                <div class="col-8">
                    <p class="text-secondary fw-bold">Suggestions for you</p>
                </div>
                <div class="col-4">
                    <a href="#" class="text-decoration-none text-dark fw-bold">See all</a>
                </div>
            </div>
            <div class="row">
                @foreach ($suggested_users as $user)
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
        </div>
    </div>
@endsection
