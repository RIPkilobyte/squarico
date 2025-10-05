@extends('app')
@section('content')

@include('header2')

<div class="container text-center">
    <div class="row mb-5 mt-lg-5">
        <div class="col-xxl-10 offset-xxl-1">
            @include('errors')
            <div class="row">
                <div class="col-lg-6 pr-lg-3">
                    <div class="login__wrapper bg-blueLight p-3">
                        <div class="p-lg-5">
                            <form action="{{ route('login') }}"  method="post" autocomplete="off">
                                @csrf
                                <h2 class="title mb-4 text-white">Login</h2>
                                <div class="form-floating">
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="floatingInput" placeholder="Email">
                                    <label for="floatingInput">Email</label>
                                </div>
                                <div class="form-floating my-3">
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="floatingPassword" placeholder="Password">
                                    <label for="floatingPassword">Password</label>
                                    <a href="#" class="pwdControl ctrl1 ctrl-show">Show</a>
                                </div>
                                <button class="w-100 btn btn-theme btn-blue" type="submit">Login</button>
                                <div class="mt-3 text-right">
                                    <a href="{{ route('forgot-password') }}" class="link-color">Forgotten your password?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 pl-lg-3 pt-4 pt-lg-0">
                    <div class="login__wrapper login__wrapper-right p-3">
                        <div class="p-lg-5">
                            <h2 class="title">Register your interest</h2>
                            <p class="login__desc my-5">
                                The registration is commitment-free and will allow you to get exclusive investment deals. You can delete your profile at any time.
                            </p>
                            <a class="w-100 btn btn-theme btn-blue" href="{{ route('register') }}">Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('footer')
@endsection