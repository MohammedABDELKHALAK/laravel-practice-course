<div class="card mt-4">

    <div class="card-body">
        <h4 class="card-title">{{ $title }}</h4>
    </div>
    <ul class="list-group list-group-flush">

        @if (empty(trim($slot)))

            @foreach ($items as $item)
                <li class="list-group-item">
                    {{-- <span class="badge bg-success"> {{ $item->comment_count }} </span> --}}
                    {{ $item }}
                </li>
            @endforeach
        @else
            {{ $slot }}
        @endif

    </ul>
</div>
