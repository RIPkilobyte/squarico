@extends('user')
@section('right-content')

    <div class="m-lg-5 p-lg-5 text-center">
        <h2 class="title mb-4 mb-sm-5">Your password</h2>
        <p class="text-success fw-bold">You successfully changed your password!</p>
        <div class="sign-done mx-auto mt-4 mb-5">✓️</div>
        <a class="btn btn-theme btn-blue mx-auto px-5" href="{{ route('opportunities') }}">View our investment opportunities</a>
    </div>

@endsection
