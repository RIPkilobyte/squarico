@extends('app')
@section('content')

@include('header1')

<div class="container my-5">
    @include('errors')
    <div class="row">
        <div class="col-lg-6">

            <div class="row align-items-center mb-4">
                <div class="col-md-6 title">
                    Create user
                </div>
            </div>

            <div class="col-md-6"><h4>Details</h4></div>

            <form action="{{ route('user', 0) }}" method="post" autocomplete="off">
                @csrf
                <input type="hidden" name="id" value="0">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="firstName" class="form-control @error('firstName') is-invalid @enderror" id="floatingFirstName" placeholder="*First name" value="{{ old('firstName') }}">
                            <label for="floatingFirstName">*First name</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="lastName" class="form-control @error('lastName') is-invalid @enderror" id="floatingLastName" placeholder="*Last name" value="{{ old('lastName') }}">
                            <label for="floatingLastName">*Last name</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="floatingEmail" placeholder="*Email" value="{{ old('email') }}">
                            <label for="floatingEmail">*Email</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="floatingPhone" placeholder="*Phone number" value="{{ old('phone') }}">
                            <label for="floatingPhone">*Phone number</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="date" name="birth" class="form-control @error('birth') is-invalid @enderror" id="floatingBirth" placeholder="*Date of birth" value="{{ old('birth') }}">
                            <label for="floatingBirth">*Date of birth</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="nationality" class="form-control @error('nationality') is-invalid @enderror" id="floatingNationality" placeholder="*Nationality" value="{{ old('nationality') }}">
                            <label for="floatingNationality">*Nationality</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="house" class="form-control @error('house') is-invalid @enderror" id="floatingHouse" placeholder="*House name or number" value="{{ old('house') }}">
                            <label for="floatingHouse">*House name or number</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="address1" class="form-control @error('address1') is-invalid @enderror" id="floatingAddress" placeholder="*Address 1st line" value="{{ old('address1') }}">
                            <label for="floatingAddress">*Address 1st line</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input type="text" name="address2" class="form-control @error('address2') is-invalid @enderror" id="floatingAddressTwo" placeholder="Address 2nd line (optional)" value="{{ old('address2') }}">
                            <label for="floatingAddressTwo">Address 2nd line (optional)</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" id="floatingCity" placeholder="*City / Town" value="{{ old('city') }}">
                            <label for="floatingCity">*City / Town</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="zip" class="form-control @error('zip') is-invalid @enderror" id="floatingZip" placeholder="*Post code" value="{{ old('zip')  }}">
                            <label for="floatingZip">*Post code</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="country" class="form-control @error('country') is-invalid @enderror" id="floatingCountry" placeholder="Country" value="{{ old('country') }}">
                            <label for="floatingCountry">*Country</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" name="password" class="form-control @error('password') is-invalid @enderror" id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">*Password</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button class="w-100 btn btn-lg btn-blue mt-2" type="submit">Create</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
