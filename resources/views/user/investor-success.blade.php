@extends('user')
@section('right-content')

<div class="m-lg-5 p-lg-5 text-center">
    <h2 class="title mb-4 mb-sm-5">My investor type</h2>
    <div class="fw-bold">
        <p class="text-success">Your selection is complete!</p>
        <p><span class="text-success">You have selected</span> {{ $investorName }}</p>
        <p class="text-success">as the type that describes you best.</p>
    </div>
    <div class="sign-done mx-auto my-4">✓️</div>
    <a class="btn btn-theme btn-blue mx-auto px-5" href="{{ route('opportunities') }}">View our investment opportunities</a>
    <div class="clearfix mb-4"></div>
    <a class="text-decoration-underline color-blueDirty fs-16" href="{{ route('investor') }}?redirect=details">Change your investor type</a>
</div>

@endsection
