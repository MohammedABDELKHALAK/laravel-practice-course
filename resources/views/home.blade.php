@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>



                    <div class="card-body">


                            {{-- this second method to make a page for super admin 
                        but you need first to give the Gate in AutServiceProvider --}}
                        
                        {{-- @can('page.secret') --}}
                            <p><a href=" {{ route('secret') }}">administration</a></p>
                        {{-- @endcan --}}

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
