@extends('app')
@section('content')

@if(Auth::check())
    @include('header1')
@else
    @include('header2')
@endif

<main class="bg-blueTransparent py-sm-5">
    <div class="container">
        @include('errors')
        @if('register' != $redirect)
            <a class="d-block py-3 mt-sm-0" href="{{ route('investor.complete') }}"><i class="fa-sharp fa-solid fa-arrow-left"></i> Go back</a>
        @endif
        <div class="row">
            <div class="col-lg-6 bg-blueLight py-4 p-sm-5 text-white">
                <form action="{{ route('investor') }}"  method="post" autocomplete="off">
                    @csrf
                    <input type="hidden" name="redirect" value="{{ $redirect }}">
                    <div class="text-center text-sm-start">
                        <h1 class="title">Choose investor type:</h1>
                        <p class="mb-4 my-sm-3">What investor type applies to you?</p>
                    </div>
                    <div class="list-group">
                        <div class="d-flex align-items-center border border-2 border-white px-4 px-sm-4 py-3 mb-3 invetorType__active">
                            <input class="invetorType__checkbox cursor-pointer me-3" type="radio" name="type" value="self" id="type1">
                            <label class="cursor-pointer" for="type1"><b>I am a Self-certified sophisticated investor</b></label>
                        </div>
                        <div class="d-flex align-items-center border border-2 border-white px-4 px-sm-4 py-3 mb-3">
                            <input class="invetorType__checkbox cursor-pointer me-3" type="radio" name="type" value="certified" id="type2">
                            <label class="cursor-pointer" for="type2"><b>I am a Certified sophisticated investor</b></label>
                        </div>
                        <div class="d-flex align-items-center border border-2 border-white px-4 px-sm-4 py-3 mb-3">
                            <input class="invetorType__checkbox cursor-pointer me-3" type="radio" name="type" value="high" id="type3">
                            <label class="cursor-pointer" for="type3"><b>I am a High net worth investor</b></label>
                        </div>
                    </div>
                    <button class="w-100 btn btn-theme btn-blue" type="submit">Select this type of investor</button>
                </form>
            </div>
            <div class="col-lg-6 bg-white fs-16 py-4 p-sm-5 invetorType__result result">
            </div>
        </div>
    </div>
</main>
@push('scripts')
<script type="text/javascript">
    $("input[type=radio]").change(function(){
        $.get('{{ route('investor.description', '') }}/'+$(this).attr('id'), function(data) {
            $('.result').html(data);
        });
        $('.invetorType__active').removeClass('invetorType__active')
        $(this).parent().addClass('invetorType__active');
    });
    $("#type1").click();
$().ready(function() {
    @if('self' == $user->investor_type)
        $("#type1").click();
    @elseif('certified' == $user->investor_type)
        $("#type2").click();
    @elseif('high' == $user->investor_type)
        $("#type3").click();
    @endif
});
</script>
@endpush
@endsection
