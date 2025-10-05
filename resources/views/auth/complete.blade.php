@extends('app')
@include('errors')
@section('content')

<div class="vh-100 bg-blueTransparent">
    <div class="container">
        <div class="row py-lg-5">
            <div class="col-lg-6 offset-lg-3 bg-white p-4 p-sm-5 text-center">
                <a class="d-flex justify-content-center" href="/">
                    <div class="header2__logo"></div>
                </a>
                <h1 class="title mt-5">Complete your registration</h1>
                <img class="my-5 px-5" src="{{ asset('img/mailcover.svg') }}">
                <p class="mb-3">We’ve sent you an email with your unique verification link. Just click on the link in the email to verify your account.</p>
                <p>This could take up to a few minutes to come through and also please keep an eye on your Junk folder.</p>
            </div>
        </div>
    </div>
</div>
@endsection
