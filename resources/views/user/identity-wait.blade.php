@extends('user')
@section('right-content')

    <div class="m-lg-5 p-lg-5 text-center">
        <h2 class="title mb-4 mb-sm-5">My documents:</h2>
        <p class="fw-bold color-blueDirty">Thank you for the uploaded documents</p>
        <p class="fw-bold color-blueDirty">We will review them shortly and will let you know the results.</p>
        <div class="my-5"><i class="fa-solid fa-hourglass-half fa-2xl color-blueDirty"></i></div>
        <a class="w-100 btn btn-theme btn-blue" href="{{ route('opportunities') }}">View our investment opportunities</a>
        <a class="d-block mt-5 text-decoration-underline color-blueDirty" href="{{ route('identity.change') }}">Change the uploaded documents</a>
    </div>

@endsection
