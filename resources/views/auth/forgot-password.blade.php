@extends('app')
@include('errors')
@section('content')

@include('header2')
<div class="container">
    <div class="row my-lg-5 text-white">
        <div class="col-lg-4 offset-lg-4 bg-blueLight p-4 p-sm-5 text-center">
            <form action="{{ route('forgot-password') }}"  method="post">
                @csrf
                <h2 class="title">Forgotten your password?</h2>
                <p class="py-4">Enter your email address, and we'll send you a renewal link.</p>
                <div class="form-floating">
                    <input type="email" name="email" class="form-control" id="floatingInput" placeholder="Email">
                    <label for="floatingInput">Email</label>
                </div>
                <button class="w-100 btn btn-theme btn-blue my-3" type="submit">Submit</button>
            </form>
            <a class="link-color" href="{{ route('login') }}">< Back to Login</a>
        </div>
    </div>
</div>
@include('footer')
@endsection
