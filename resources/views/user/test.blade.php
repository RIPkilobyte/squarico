@extends('user')
@section('right-content')

<div class="my-lg-5 p-lg-5 text-center">
    <h2 class="title mb-4 mb-sm-5">Investor appropriateness test</h2>
    @if ($message)
        <div class="alert alert-danger" role="alert">{{ $message }}</div>
    @endif
    <p>We have to make sure that you as an investor understand risk that are associated with investments in our products. Please answer the following questions.</p>
    <p>We will review them shortly and will let you know the results.</p>
    <a class="btn btn-theme btn-blue mx-auto px-5 mt-4 mt-sm-5" href="{{ route('test.process') }}">Start</a>
</div>

@endsection
