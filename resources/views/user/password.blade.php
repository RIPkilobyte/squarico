@extends('user')
@section('right-content')

<div class="m-lg-5 p-lg-5 text-center">
    <h2 class="title mb-4 mb-sm-5">Change my password</h2>
    <form action="{{ route('profile.password') }}" method="post">
        @csrf

        <div class="form-floating">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Create new password">
            <label for="floatingPassword">Create new password</label>
            <a href="#" class="pwdControl ctrl1 ctrl-show">Show</a>
        </div>

        <div class="row">
            <div class="col-xxl-10 offset-xxl-2 text-start fs-16 py-3 ps-xxl-4">
                <ul>
                    <li>Must be at least 8 characters in length</li>
                    <li>Must have at least one digit</li>
                    <? /*
                    <li>Must contain at least one lowercase letter</li>
                    <li>Must include at least one uppercase letter</li>
                    <li>Must contain a special character</li>
                    */ ?>
                </ul>
            </div>
        </div>

        <button class="btn btn-theme btn-blue mx-auto px-5" type="submit">Change password</button>
    </form>
</div>

@endsection
