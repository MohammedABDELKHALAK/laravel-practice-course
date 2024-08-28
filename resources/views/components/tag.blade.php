
<div>
    @foreach ($tags as $tag)
    <span class="badge bg-success"> <a href="{{ route('post.tag.index', [ 'id' =>  $tag->id, 'tagname' => $tag->name ]) }}"> {{ $tag->name }}  </a></span>
@endforeach

</div>
