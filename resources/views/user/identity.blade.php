@extends('user')
@section('right-content')
    <h1 class="text-center title">My documents:</h1>
    <p class="mt-4">To comply with UK regulations, we must take a copy of your ID and proof of address before you can make any investments. You can take pictures of them on your mobile phone and upload their copies (good quality please) in the boxes below:</p>
    <form class="text-center text-sm-start" action="{{ route('identity') }}" method="post" enctype="multipart/form-data">
        @csrf

        <hr class="my-4">

        <div class="row align-items-center">
            <div class="col-sm-4">
                <p class="fw-bold mb-2 mb-sm-0">A copy of my ID</p>
            </div>
            <div class="col-sm-8">
                <input class="form-control" type="file" name="copyId" id="floatingCopyId" />
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8 offset-sm-4">
                <p class="fs-16 color-blueDirty">Any of these documents: Valid passport; Valid driving licence; National Identity Card;</p>
            </div>
        </div>

        <hr class="my-4">

        <div class="row align-items-center">
            <div class="col-sm-4">
                <p class="fw-bold mb-2 mb-sm-0">A proof of my address</p>
            </div>
            <div class="col-sm-8">
                <input class="form-control" type="file" name="address" id="floatingAddress" />
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8 offset-sm-4">
                <p class="fs-16 color-blueDirty">Any of these documents: Utility bill (excluding mobile phone bill); Bank statement; First page only (if there are multiple pages). It has to be dated within the latest 6 months.</p>
            </div>
        </div>

        <hr class="my-4">

        <div class="text-center">
            <p>Please choose both documents before pressing the “Upload” button.</p>
            <button class="btn btn-theme btn-blue px-5 mt-4" type="submit">Upload</button>
        </div>
    </form>
@endsection
