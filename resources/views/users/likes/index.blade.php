@extends('layouts.app')

@section('title', 'Likes')

@section('content')
<div class="">
    @if ($liked_posts)
        <div class="row">
            <h2 class="text-secondary">Likes</h2>
            @foreach ($liked_posts as $post)
                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="{{ route('post.show', $post->id) }}"><img src="{{ $post->image }}" alt="post id {{ $post->id }}" class="grid-img"></a>
                </div>
            @endforeach
        </div>
    @else
        <h3 class="text-muted text-center">No Post Yet</h3>
    @endif
</div>
@endsection
