@if(session()->has('status'))
<div class="alert alert-info" role="alert">
    <strong>info: </strong> {{ session()->get('status')}}
</div>
@endif

{{-- @if (Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
@endif --}}
