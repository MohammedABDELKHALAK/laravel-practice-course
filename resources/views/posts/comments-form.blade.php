@auth
    <div class="container">
    
        <form method="POST" action="{{ route('posts.comments.store', ['post' => $id ]) }} ">
            @csrf

            <div class="form-group">
                <label for="comment"> Add Comment: </label>
               
                <textarea class="form-control" name="comment" id="comment" rows="3"></textarea>
            </div>

            {{-- @if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
        
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif --}}

    {{-- you can write prop as kabeb case like this my-class but in component class and blade file use kamel case like myClass --}}
    <x-error my-class="warning"></x-error>

            <button class="btn btn-primary mt-2" name="btn1" id="comment-btn" type="submit">Add Comment</button>
        </form>
    </div>
@else

<div>
    <a href=" {{ route ('login') }}" class="btn btn-success btn-sm">Sign In</a> to add a comment!!
</div>
@endauth

