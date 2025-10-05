@extends('app')
@include('errors')
@section('content')

@include('header2')

<div class="vh-100 bg-blueTransparent">
    <div class="container">
        <div class="row py-lg-5">
            <div class="col-lg-6 offset-lg-3 bg-white p-4 p-sm-5 text-center">
                <a class="d-flex justify-content-center" href="/">
                    <div class="header2__logo"></div>
                </a>
                <h1 class="title mt-5">Verification Seccessfull</h1>
                <img class="my-5 px-5" src="{{ asset('img/mailcover.svg') }}">
            </div>
        </div>
    </div>
</div>
@include('footer')
@endsection
