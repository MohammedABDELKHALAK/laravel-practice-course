@extends('layouts.app')

@section('content')
{{-- this to edit user name and picture --}}
{{-- form>.row>.col-md-4>h5{Select a defference avatar}+img.img-thumbnail+input:file.form-control-file^.col-md-8>.form-group>label+input#form-control --}}
<form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="row">
        <div class="col-md-4">
            <h5>Select a defference avatar</h5>
            <img src="" alt="" class="img-thumbnail avatar">
            <input type="file" name="avatar" id="avatar" class="form-control-file">
            <button class="btn btn-info btn-block" type="submit"> Create</button>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <label for="avatar">Name</label>
                <input type="text" name="name" id="name" class="form-control">
            </div>
        </div>
    </div>
</form>



@endsection