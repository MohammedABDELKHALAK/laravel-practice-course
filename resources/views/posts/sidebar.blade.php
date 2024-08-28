<x-card title="Most Post Commanted">

    @foreach ($scopeMostPostCommanted as $post)
        <li class="list-group-item">
            <span class="badge bg-success"> {{ $post->comment_count }} </span>
            <a href="">{{ $post->title }}</a>
        </li>
    @endforeach

</x-card>

<x-card title="MostMost Users Active" :items="collect($scopeMostUsersHavePosts)->pluck('name')"> </x-card>

<x-card title="Most Users Active In Last Month" :items="collect($scopeMostUsersHavePostsInLastMonth)->pluck('name')"> </x-card>


<div class="card mt-4">

    <div class="card-body">
        <h4 class="card-title">Most Users Active In Last Month</h4>
    </div>
    <ul class="list-group list-group-flush">
        @foreach ($scopeMostUsersHavePostsInLastMonth as $user)
            <li class="list-group-item">
                <span class="badge bg-info"> {{ $user->post_count }} </span>
                {{ $user->name }}
            </li>
        @endforeach
    </ul>
</div>

</div>
