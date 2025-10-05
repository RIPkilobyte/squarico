@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">{{ $error }}</div>
    @endforeach
@endif
@if (session('status'))
    <div class="alert alert-primary" role="alert">{{ session('status') }}</div>
@endif
@if (session('success'))
    <div class="alert alert-success text-center" role="alert"><h3 class="m-0">{{ session('success') }}</h3></div>
@endif
@if (session('error'))
    <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
@endif
