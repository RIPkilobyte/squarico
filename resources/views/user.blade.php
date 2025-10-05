@extends('app')
@section('content')

@include('header1')

<main class="bg-blueTransparent pt-3 pt-sm-5">
    <div class="container">

        @include('errors')

        <?php
        $bottomUserMenu = '
        <div class="mt-lg-4 mb-2 mb-lg-3">
            <a class="userMenu__title color-blueDirty fs-18 ' . (request()->is('*password') ? 'userMenu__item-active2' : '') . '" href="' . route('profile.password') . '">Password</a>
        </div>
        <a class="color-blueDirty ' . (request()->is('*delete') ? 'userMenu__item-active2' : '') . '" href="' . route('profile.delete') . '">Delete profile</a>
        ';
        ?>

        <div class="row">
            <div class="col-lg-5 col-xl-4 mb-2 mb-lg-5 pb-md-5">
                <a href="{{ route('details') }}">
                    <div class="userMenu__item {{ (request()->is('detail*')) ? 'userMenu__item-active' : '' }}">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <input type="radio" class="userMenu__radio" onclick="window.location.href='{{ route('details') }}';" {{ (request()->is('detail*')) ? 'checked' : '' }}>
                                <b>My details</b>
                            </div>
                            <div class="col-6 text-end">
                                @if($details)
                                    <p class="userMenu__notice userMenu__notice-danger">Please complete</p>
                                @else
                                    <p class="userMenu__notice userMenu__notice-success">Completed</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
                <a href="{{ route('identity') }}">
                    <div class="userMenu__item {{ (request()->is('identity*')) ? 'userMenu__item-active' : '' }}">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <input type="radio" class="userMenu__radio" onclick="window.location.href='{{ route('identity') }}';" {{ (request()->is('identity*')) ? 'checked' : '' }}>
                                <b>Documents</b>
                            </div>
                            <div class="col-6 text-end">
                                @if($documents == '1')
                                    <p class="userMenu__notice userMenu__notice-danger">Please complete</p>
                                @elseif($documents == '2')
                                    <p class="userMenu__notice color-blueDirty pe-0">Under review <i class="fa-solid fa-hourglass-half fa-xl mx-1"></i></p>
                                @elseif($documents == '3')
                                    <p class="userMenu__notice userMenu__notice-success">Completed</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
                <a href="{{ route('test') }}">
                    <div class="userMenu__item {{ (request()->is('test*')) ? 'userMenu__item-active' : '' }}">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <input type="radio" class="userMenu__radio" onclick="window.location.href='{{ route('test') }}';" {{ (request()->is('test*')) ? 'checked' : '' }}>
                                <b>Investor test</b>
                            </div>
                            <div class="col-6 text-end">
                                @if($test)
                                    <p class="userMenu__notice userMenu__notice-danger">Please complete</p>
                                @else
                                    <p class="userMenu__notice userMenu__notice-success">Completed</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
                <a href="{{ route('investor.complete') }}">
                    <div class="userMenu__item {{ (request()->is('investor*')) ? 'userMenu__item-active' : '' }}">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <input type="radio" class="userMenu__radio" onclick="window.location.href='{{ route('investor.complete') }}';" {{ (request()->is('investor*')) ? 'checked' : '' }}>
                                <b>Investor type</b>
                            </div>
                            <div class="col-6 text-end">
                                <p class="userMenu__notice userMenu__notice-success">Completed</p>
                            </div>
                        </div>
                    </div>
                </a>
                <div class="d-none d-lg-block">
                    <?=$bottomUserMenu?>
                </div>
            </div>

            <div class="col-lg-7 col-xl-8 ps-md-4 mb-4 mb-lg-5 {{ (request()->is('test-process')) ? 'order-first order-lg-0' : '' }}">
                <div class="userRight p-4">
                    @yield('right-content')
                </div>
            </div>
        </div>
        <div class="d-block d-lg-none pb-4">
            <?=$bottomUserMenu?>
        </div>
    </div>
</main>

@endsection