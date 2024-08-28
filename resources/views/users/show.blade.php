@extends('layouts.app')

@section('content')

{{-- form>.row>.col-md-4>h5{Select a defference avatar}+img.img-thumbnail+input:file.form-control-file^.col-md-8>.form-group>label+input#form-control --}}

    <div class="row">
        <div class="col-md-4">
            <h5>{{ $user->name }}</h5>
            <img src="{{ $user->images->path }}" alt="" class="img-thumbnail my-2 avatar">
            <a class="btn btn-warning" href="{{ route('users.edit', ['user' => $user->id]) }}">Edit Your Picture</a>
        </div>
        <div class="col-md-8">
            


        </div>
    </div>




@endsection