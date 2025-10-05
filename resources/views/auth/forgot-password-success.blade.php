@extends('app')
@include('errors')
@section('content')

@include('header2')

<div class="vh-100 bg-blueTransparent">
    <div class="container">
        <div class="row py-lg-5">
            <div class="col-lg-4 offset-lg-4 bg-white p-4 p-sm-5 text-center">
                <img class="mb-5 px-5" src="{{ asset('img/mailcover.svg') }}">
                <p><b>Your renewal link was sent to:</b></p>
                <p class="my-3">{{ $email }}</p>
                <p class="mb-3" style="color: #8bb5d9;">You might need to check your junk box</p>
                <a class="link-color" href="{{ route('login') }}">< Back to Login</a>
            </div>
        </div>
    </div>
</div>

@include('footer')
@endsection
