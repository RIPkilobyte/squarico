@extends('user')
@section('right-content')

    <div class="m-lg-5 p-lg-5 text-center">
        <h2 class="title mb-4 mb-sm-5">Deleting your profile</h2>
        <div class="bg-black text-white p-5 mb-4 mb-sm-5">
            <form action="{{ route('profile.delete') }}" method="post" id="formDelete">
                @csrf
                <p class="fw-bold mb-3">Do you really want to delete your profile?</p>

                <button class="btn btn-theme btn-red px-5 mb-3 mb-sm-0" type="button" onclick="deleteProfile()">Yes</button>
                <a class="btn btn-theme btn-success px-5 mb-3 mb-sm-0" href="{{ route('opportunities') }}">No</a>
            </form>
        </div>
        <p>You can automatically delete this profile if you currently don’t have any active investments. Otherwise, please contact our admin for assistance by this email: <a href="mailto:support@squarico.com">support@squarico.com</a></p>
    </div>

    @push('scripts')
        <script>
            function deleteProfile() {
                if(confirm("Are you sure to delete your profile?")) {
                    $('#formDelete').submit();
                }
            }
        </script>
    @endpush

@endsection
