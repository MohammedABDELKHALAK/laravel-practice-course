@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-8">
            <div class="container">

                {{-- @if ($tab != 'archive')
                {{dd(true);}}
             @endif --}}

                <h1 class="h-index">List of Posts</h1>

                {{-- <nav class="nav nave-tabs nav-stacked my-5">
                <a class="nav-link @if ($tab == 'list') active @endif " href="/posts"> list</a>
                <a class="nav-link @if ($tab == 'archive') active @endif " href="/posts/archive">archieve </a>
                <a class="nav-link @if ($tab == 'all') active @endif " href="/posts/all"> all </a>
             </nav> --}}

                {{-- <ul class="nav nav-tabs">
                    <li class="nav-item"> <a class="nav-link @if ($tab === 'list') active @endif " href="/posts">
                            list</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link @if ($tab === 'archive') active @endif "
                            href="/posts/archive">archieve </a> </li>
                    <li class="nav-item"> <a class="nav-link @if ($tab === 'all') active @endif "
                            href="/posts/all"> all
                        </a> </li>

                </ul> --}}

                <ul class="list-group ">
                    <div class="mt-2">
                        <h2>{{ $posts->count() }} Post(s)</h2>
                    </div>

                    @foreach ($posts as $post)
                        @if ($post->created_at->diffInHours() < 1)
                            <x-badge type="success">new</x-badge>
                        @else
                            <x-badge type="black">old</x-badge>
                        @endif

                        @if ($post->image)
                            <img src="{{ Storage::url($post->image->path) }}" class="img-fluid rounded mt-3" alt="">
                        @endif

                        <li class="list-group-item my-3">

                            <h1>
                                <a class="title" href="{{ route('posts.show', ['post' => $post->id]) }}">
                                    {{-- this is show for admin i gave the privilige to show deleted posts 
                                    by using Scope global this is a new way to do like this opiration --}}
                                    @if ($post->trashed())
                                        <del>
                                            {{ $post['title'] }}

                                        </del>
                                    @else
                                        {{ $post['title'] }}
                                    @endif
                                </a>

                            </h1>

                            <x-tag :tags="$post->tag"></x-tag>

                            @if (Auth::user() && $post->user_id == Auth::user()->id)
                                <p class="badge bg-warning text-wrap font-monospace">
                                    {{ Auth::user()->name }}
                                </p>
                            @else
                                <p class="badge bg-primary text-wrap font-monospace">
                                    {{ $post->user->name }}
                                </p>
                            @endif



                            @if ($post->comment_count)
                                <span class="badge bg-secondary">{{ $post->comment_count }} Comments</span>
                            @else
                                <span class="badge bg-danger">{{ $post->comment_count }} Comments</span>
                            @endif

                            <p>content: {{ $post->content }}</p>

                            <p> <span class="text-muted">Added in {{ $post->created_at->diffForHumans() }} ago</span> </p>
                            <p> <span class="text-muted">updated in {{ $post->updated_at->diffForHumans() }} ago</span>
                            </p>

                            {{-- <p>
                                @if ($post->active == 1)
                                    Active
                                @else
                                    Inactive
                                @endif
                            </p> --}}



                            {{-- looke at the AuthServiceProvider i give abilities to the super admin --}}
                            @can('update', $post)
                                <a class="btn btn-warning" href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit
                                    post</a>
                            @endcan



                            @if (!$post->deleted_at)
                                @can('delete', $post)
                                    <form class="delete" method="POST"
                                        action="{{ route('posts.destroy', ['post' => $post->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Delete</button>

                                    </form>
                                @endcan

                                @cannot('delete', $post)
                                    <span class="badge badge-danger">you can't delete this post</span>
                                @endcannot
                            @else
                                @can('restore', $post)
                                    <form class="delete" method="POST" action="{{ url('posts/' . $post->id . '/restore') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-success" type="submit">Restore</button>

                                    </form>
                                @endcan

                                @can('forceDelete', $post)
                                    <form class="delete" method="POST"
                                        action="{{ url('posts/' . $post->id . '/forcedelete') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Force Delete</button>
                                    @endcan
                            @endif

                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-4">

            @include('posts.sidebar')
        </div>
    </div>
    @endsection
