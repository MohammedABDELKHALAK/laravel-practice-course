@extends('layouts.app')

@section('content')
    <div class="row">

        <div class="col-8">
            <div class="container">
                @if ($posts->image)
                <img src="{{ Storage::url($posts->image->path)}}" class="img-fluid rounded mt-3" alt="" >
                @endif
                <h1> {{ $posts['title'] }}</h1>
                <x-tag :tags="$posts->tag"> </x-tag>
                <p>content: {{ $posts->content }}</p>
                <p><em>created_at: {{ $posts->created_at->diffForHumans() }}</em></p>
                {{-- <p>
                    @if ($posts->active == 1)
                        Active
                    @else
                        Inactive
                    @endif

                </p> --}}

                @include('posts.comments-form', ['id' => $posts->id])

                <hr>

                <h5 class=" container-fluid">Comments <span>({{ $posts->comment->count() }})</span></h5>
                @foreach ($posts->comment as $comment)
                    <div class="card my-3">

                        <div class="card-body">

                            <p> {{ $comment->content }}</p>
                            <p>updated_at: {{ $comment->updated_at->diffForHumans() }}</p>
                        </div>

                    </div>
                    {{-- <p>created_at: {{ $post->comment->created_at->diffForHumans() }}</p> --}}
                @endforeach
            </div>
        </div>

        <div class="col-4">

            @include('posts.sidebar')
        </div>
    @endsection
