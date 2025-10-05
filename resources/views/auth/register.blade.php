@extends('app')
@section('content')

@include('header2')

<div class="container">
    <div class="row mb-lg-5">
        <div class="col-lg-6 offset-lg-3 bg-blueLight p-4 p-sm-5 text-center">
            @include('errors')
            <form id="registerForm" action="{{ route('register') }}" method="post" autocomplete="off">
                @csrf
                <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
                <h2 class="title mb-4 text-white">Create your account</h2>
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <div class="form-floating">
                            <input type="text" name="firstName" class="form-control @error('firstName') is-invalid @enderror" id="floatingFirstName" placeholder="*First name" value="{{ old('firstName') }}">
                            <label for="floatingFirstName">*First name</label>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="form-floating">
                            <input type="text" name="lastName" class="form-control @error('lastName') is-invalid @enderror" id="floatingLastName" placeholder="*Last name" value="{{ old('lastName') }}">
                            <label for="floatingLastName">*Last name</label>
                        </div>
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="floatingEmail" placeholder="*Email" value="{{ old('email') }}">
                    <label for="floatingEmail">*Email</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="floatingPhone" placeholder="*Mobile phone" value="{{ old('phone') }}">
                    <label for="floatingPhone">*Mobile phone</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="floatingPassword" placeholder="*Create your password">
                    <label for="floatingPassword">*Create your password</label>
                    <a href="#" class="pwdControl ctrl1 ctrl-show">Show</a>
                </div>
                <div class="row">
                    <div class="col-xxl-10 offset-xxl-2 text-start fs-16 py-2">
                        <ul>
                            <li>Must be at least 8 characters in length</li>
                            <li>Must have at least one digit</li>
                        </ul>
                    </div>
                </div>

                <button class="w-100 btn btn-theme btn-blue" type="submit">Register</button>
                <div class="mt-3 text-right">
                    <a href="{{ route('login') }}" class="link-color">< Back to login</a>
                </div>
            </form>
        </div>
    </div>
</div>

@include('footer')

@push('scripts')
    <script src="https://www.google.com/recaptcha/api.js?render=6LcciGQpAAAAAO2VWB67e2bSww_9e24wuZw4XHRO"></script>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('6LcciGQpAAAAAO2VWB67e2bSww_9e24wuZw4XHRO', {action: 'submit'}).then(function(token) {
                var recaptchaResponse = document.getElementById('recaptchaResponse');
                recaptchaResponse.value = token;
            });
        });
    </script>
    <script>
        function onSubmit(token) {
            document.getElementById("registerForm").submit();
        }
    </script>
@endpush

@endsection
