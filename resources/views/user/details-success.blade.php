@extends('user')
@section('right-content')

<div class="my-lg-5 py-lg-5 text-center">
    <h2 class="title mb-5">My details:</h2>
    <p class="text-success"><b>Saved</b></p>
    <div class="sign-done mx-auto mt-3 mb-5">✓️</div>
    <a class="btn btn-theme btn-blue mx-auto px-5" href="{{ route('opportunities') }}">View our investment opportunities</a>
</div>

@endsection
