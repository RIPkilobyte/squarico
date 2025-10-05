@extends('user')
@section('right-content')

<form id="formUserDetails" action="{{ route('details') }}"  method="post" autocomplete="off">
    @csrf
    <h2 class="title text-center mb-3">My details:</h2>
    @if($details)
        <p class="text-center mb-3 color-red">Please complete</p>
    @endif
    <div class="row">
        <div class="col-md-6 mb-2 mb-sm-3">
            <div class="form-floating">
                <input type="text" name="firstName" class="form-control @error('firstName') is-invalid @enderror" id="floatingFirstName" placeholder="*First name" value="{{ $user->first_name }}">
                <label for="floatingFirstName">First name</label>
            </div>
        </div>
        <div class="col-md-6 mb-2 mb-sm-3">
            <div class="form-floating">
                <input type="text" name="lastName" class="form-control @error('lastName') is-invalid @enderror" id="floatingLastName" placeholder="*Last name" value="{{ $user->last_name }}">
                <label for="floatingLastName">Last name</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-2 mb-sm-3">
            <div class="form-floating">
                <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="floatingEmail" placeholder="*Email" value="{{ $user->email }}" disabled="disabled">
                <label for="floatingEmail">Email</label>
            </div>
        </div>
        <div class="col-md-6 mb-2 mb-sm-3">
            <div class="form-floating">
                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="floatingPhone" placeholder="*Phone number" value="{{ $user->phone }}">
                <label for="floatingPhone">Phone number</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-2 mb-sm-3">
            <div class="form-floating">
                <input type="date" name="birth" class="form-control @error('birth') is-invalid @enderror" id="floatingBirth" placeholder="*Date of birth" value="{{ $user->birth }}">
                <label for="floatingBirth">Date of birth</label>
            </div>
        </div>
        <div class="col-md-6 mb-2 mb-sm-3">
            <div class="form-floating">
                <input type="text" name="nationality" class="form-control @error('nationality') is-invalid @enderror" id="floatingNationality" placeholder="*Nationality" value="{{ $user->nationality }}">
                <label for="floatingNationality">Nationality</label>
            </div>
        </div>
    </div>

    <p><b>Home address:</b></p>
    <div class="row mt-2">
        <div class="col-md-6 mb-2 mb-sm-3">
            <div class="form-floating">
                <input type="text" name="house" class="form-control @error('house') is-invalid @enderror" id="floatingHouse" placeholder="*House name or number" value="{{ $user->house }}">
                <label for="floatingHouse">House name or number</label>
            </div>
        </div>
        <div class="col-md-6 mb-2 mb-sm-3">
            <div class="form-floating">
                <input type="text" name="address1" class="form-control @error('address1') is-invalid @enderror" id="floatingAddress1" placeholder="*Address 1st line" value="{{ $user->address1 }}">
                <label for="floatingAddress1">Address 1st line</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-2 mb-sm-3">
            <div class="form-floating">
                <input type="text" name="address2" class="form-control @error('address2') is-invalid @enderror" id="floatingAddress1" placeholder="*Address 2nd line (optional)" value="{{ $user->address2 }}">
                <label for="floatingAddress2">Address 2nd line (optional)</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-2 mb-sm-3">
            <div class="form-floating">
                <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" id="floatingCity" placeholder="*City / Town" value="{{ $user->city }}">
                <label for="floatingCity">City / Town</label>
            </div>
        </div>
        <div class="col-md-6 mb-2 mb-sm-3">
            <div class="form-floating">
                <input type="text" name="zip" class="form-control @error('zip') is-invalid @enderror" id="floatingPost" placeholder="*Post code" value="{{ $user->zip }}">
                <label for="floatingPost">Post code</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-2 mb-sm-3">
            <div class="form-floating">
                <input type="text" name="country" class="form-control @error('country') is-invalid @enderror" id="floatingCountry" placeholder="*Country" value="{{ $user->country }}">
                <label for="floatingCountry">Country</label>
            </div>
        </div>
    </div>
    <button class="w-100 btn btn-theme btn-blue" type="submit">Save Changes</button>
</form>

@endsection
