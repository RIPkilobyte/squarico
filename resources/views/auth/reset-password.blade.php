@php($title = 'Setting new password')
@extends('app')
@section('content')

    @include('header2')

    <div class="container text-center">
        <div class="row mb-5 mt-lg-5">
            <div class="col-xxl-6 offset-xxl-3">
                @include('errors')
                <div class="row">
                    <div class="col-lg-12">
                        <div class="login__wrapper bg-blueLight p-3">
                            <div class="p-lg-5">
                                <form action="{{ route('password.update') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ request()->route('token') }}">
                                    <h2 class="title mb-4 text-white">New password</h2>
                                    <div class="form-floating">
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="floatingInput" placeholder="Email" value="{{ old('email', $request->email)}}">
                                        <label for="floatingInput">Email</label>
                                    </div>

                                    <div class="form-floating my-3">
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="floatingPassword" placeholder="Password">
                                        <label for="floatingPassword">Password</label>
                                        <a href="#" class="pwdControl ctrl1 ctrl-show">Show</a>
                                    </div>

                                    <div class="form-floating my-3">
                                        <input type="password" name="password_confirmation" class="form-control floatingPassword2 @error('password_confirmation') is-invalid @enderror" id="floatingPasswordConfirm" placeholder="Confirm password">
                                        <label for="floatingPasswordConfirm">Confirm password</label>
                                        <a href="#" class="pwdControl ctrl2 ctrl-show">Show</a>
                                    </div>
                                    <button class="w-100 btn btn-theme btn-blue" type="submit">Set new password</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('footer')
@endsection
