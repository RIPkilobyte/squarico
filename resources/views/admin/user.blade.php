@extends('app')
@section('content')

@include('header1')

<div class="container my-5">
    @include('errors')

    <div class="row">
        <div class="col-lg-6">

            <div class="row align-items-center mb-4">
                <div class="col-md-6 title">
                    User # {{ $id }}
                </div>
                <div class="col-md-2">
                    @if($user->attention)
                        <a href="#" onclick="disActivateAttention({{ $user->id }})"><span class="fa fa-solid fa-exclamation-circle fa-2x color-red"></span></a>
                    @else
                        <a href="#" onclick="activateAttention({{ $user->id }})"><span class="fa fa-solid fa-exclamation-circle fa-2x text-secondary"></span></a>
                    @endif
                </div>
                <div class="col-md-4">
                    @if($user->approved)
                        <button class="w-100 btn btn-lg btn-success" type="button" onclick="disapproveUser({{ $user->id }})">Approved</button>
                    @else
                        <button class="w-100 btn btn-lg btn-secondary" type="button" onclick="approveUser({{ $user->id }})">Not approved</button>
                    @endif
                </div>
            </div>

            <div id="detail" class="col-md-6"><h4>Details</h4></div>
            @if (session('detailsStatus'))
                <div class="alert alert-success text-center" role="alert">{{ session('detailsStatus') }}</div>
            @endif

            <form action="{{ route('user', $id) }}" method="post" autocomplete="off">
                @csrf
                <input type="hidden" name="id" value="{{ $id }}">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            @php($value = old('firstName') ?? $user->first_name)
                            <input type="text" name="firstName" class="form-control @error('firstName') is-invalid @enderror" id="floatingFirstName" placeholder="*First name" value="{{ $value }}">
                            <label for="floatingFirstName">*First name</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            @php($value = old('lastName') ?? $user->last_name)
                            <input type="text" name="lastName" class="form-control @error('lastName') is-invalid @enderror" id="floatingLastName" placeholder="*Last name" value="{{ $value }}">
                            <label for="floatingLastName">*Last name</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            @php($value = old('email') ?? $user->email)
                            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="floatingEmail" placeholder="*Email" value="{{ $value }}">
                            <label for="floatingEmail">*Email</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            @php($value = old('phone') ?? $user->phone)
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="floatingPhone" placeholder="*Phone number" value="{{ $value }}">
                            <label for="floatingPhone">*Phone number</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            @php($value = old('birth') ?? $user->birth)
                            <input type="date" name="birth" class="form-control @error('birth') is-invalid @enderror" id="floatingBirth" placeholder="*Date of birth" value="{{ $value }}">
                            <label for="floatingBirth">*Date of birth</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            @php($value = old('nationality') ?? $user->nationality)
                            <input type="text" name="nationality" class="form-control @error('nationality') is-invalid @enderror" id="floatingNationality" placeholder="*Nationality" value="{{ $value }}">
                            <label for="floatingNationality">*Nationality</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            @php($value = old('house') ?? $user->house)
                            <input type="text" name="house" class="form-control @error('house') is-invalid @enderror" id="floatingHouse" placeholder="*House name or number" value="{{ $value }}">
                            <label for="floatingHouse">*House name or number</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            @php($value = old('address1') ?? $user->address1)
                            <input type="text" name="address1" class="form-control @error('address1') is-invalid @enderror" id="floatingAddress" placeholder="*Address 1st line" value="{{ $value }}">
                            <label for="floatingAddress">*Address 1st line</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-floating">
                            @php($value = old('address2') ?? $user->address2)
                            <input type="text" name="address2" class="form-control @error('address2') is-invalid @enderror" id="floatingAddressTwo" placeholder="Address 2nd line (optional)" value="{{ $value }}">
                            <label for="floatingAddressTwo">Address 2nd line (optional)</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            @php($value = old('city') ?? $user->city)
                            <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" id="floatingCity" placeholder="*City / Town" value="{{ $value }}">
                            <label for="floatingCity">*City / Town</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            @php($value = old('zip') ?? $user->zip)
                            <input type="text" name="zip" class="form-control @error('zip') is-invalid @enderror" id="floatingZip" placeholder="*Post code" value="{{ $value }}">
                            <label for="floatingZip">*Post code</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating">
                            @php($value = old('country') ?? $user->country)
                            <input type="text" name="country" class="form-control @error('country') is-invalid @enderror" id="floatingCountry" placeholder="Country" value="{{ $value }}">
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
                        <button class="w-100 btn btn-lg btn-blue mt-3" type="submit">Update</button>
                    </div>
                </div>
            </form>

        </div>
        <div class="col-lg-6 ps-lg-5">

            <div class="row align-items-center py-2 mb-4">
                <div class="col-8">
                    Registration date: {{ date('d/m/Y', strtotime($user->created_at)) }}
                </div>
                <div class="col-4 text-end">
                    <a href="#" onclick="deleteUser({{ $user->id }})">Delete profile</a>
                </div>
            </div>

            <h4 id="notes">Investment: {{ $notCompleted }} / {{ $completed }}</h4>

            @if (session('notesSuccess'))
                <div class="alert alert-success text-center" role="alert">{{ session('notesSuccess') }}</div>
            @endif

            <form class="pt-1" action="{{ route('user.notes', $id) }}" method="post" autocomplete="off">
                @csrf
                @php($value = old('notes') ?? $user->notes)
                <textarea name="notes" class="form-control @error('notes') is-invalid @enderror mb-2" placeholder="Internal notes" rows="17" id="floatingNotes">{{ $value }}</textarea>
                <div class="text-center">
                    <button class="btn btn-lg btn-blue px-5 mt-4" type="submit">Save</button>
                </div>
            </form>

        </div>
    </div>

    <hr class="my-5">

    <div id="verification" class="row">
        <div class="col-lg-6">
            @if($user->identity)
                @php($verifClass = 'bg-success text-white')
            @else
                @if(isset($files[0]))
                    @php($verifClass = 'bg-danger text-white')
                @else
                    @php($verifClass = 'bg-blueTransparent')
                @endif
            @endif
            @if (session('verificationStatus'))
                <div class="alert alert-success text-center" role="alert">{{ session('verificationStatus') }}</div>
            @endif
            <div id="adminVerif" class="{{ $verifClass }} px-4 py-3 rounded-2">
                <a class="adminVerif__link" data-bs-toggle="collapse" href="#collapseVerif" role="button" aria-expanded="false" aria-controls="collapseVerif">
                    <div class="row">
                        <div class="col-10">
                            <h4 class="m-0">Identity verification</h4>
                        </div>
                        <div class="col-2 text-end">&darr;</div>
                    </div>
                </a>
            </div>
            <div class="collapse bg-blueTransparent px-4 py-3" id="collapseVerif">
                @foreach($files as $file)
                    <div class="row">
                        <div class="col-md-2">
                            <div class="investmens__file mb-2">
                                @if('copy_id' === $file->entity)
                                    ID_copy
                                @elseif('address' === $file->entity)
                                    Address
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <a class="text-decoration-underline" href="{{ route('download', $file->id) }}">{{ $file->original_name }}</a>
                        </div>
                        <div class="col-md-3">
                            {{ date('d/m/Y', strtotime($file->created_at)) }}
                        </div>
                        <div class="col-md-1">
                            <a href="#" onclick="deleteFile({{ $file->id }})">X</a>
                        </div>
                    </div>
                @endforeach
                <form action="{{ route('upload') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $id }}">
                    <div class="border border-1 px-4 py-3">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="floatingEntity">Upload files</label>
                                <select class="form-control" name="entity" id="floatingEntity">
                                    <option value="copy_id">Copy of ID</option>
                                    <option value="address">Proof of address</option>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <label for="floatingFile">Choose file</label>
                                <input class="form-control" type="file" name="file" id="floatingFile" />
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-lg btn-blue mt-3" type="submit">Upload</button>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        @if($user->identity)
                            <button class="btn btn-lg btn-danger" type="button" onclick="unVerifyUser({{ $user->id }})">Cancel verification</button>
                        @else
                            <button class="btn btn-lg btn-success" type="button" onclick="verifyUser({{ $user->id }})">Verify</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-6 ps-lg-5">
            @if($user->test == 'Passed')
                @php($testClass = 'bg-success text-white')
            @else
                @php($testClass = 'bg-blueTransparent')
            @endif

            <div class="{{ $testClass }} rounded-2 px-4 py-3">
                <div class="row">
                    <div class="col-md-6">
                        Appropriateness test
                    </div>
                    <div class="col-md-6 text-end">
                        {{ $user->test }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-5">

    <div id="projects">
        <h2>Investments</h2>
        @if (session('projectsStatus'))
            <div class="alert alert-success text-center" role="alert">{{ session('projectsStatus') }}</div>
        @endif
        <form class="mt-3 mb-4" action="{{ route('user.project') }}" method="post" autocomplete="off">
            @csrf
            <input type="hidden" name="userId" value="{{ $id }}">
            <div class="row align-items-center">
                <div class="col-6 col-lg-2">
                    <select class="form-control" name="projectId" id="floatingProjects">
                        <option value="0">-- Project --</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-lg-2">
                    <button class="w-100 btn btn-lg btn-blue" type="submit">Add investment</button>
                </div>
            </div>
        </form>
    </div>

    <table id="table1" class="table table-bordered table-hover table-cursor-pointer">
        <thead>
            <tr>
                <th>No</th>
                <th>Project</th>
                <th>£ invested</th>
                <th>Sq.feet</th>
                <th>£ Ex.profit</th>
                <th>Exit date</th>
                <th>Notes</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($investments as $investment)
            @if($investment['project'])
                <form action="{{ route('user.investments') }}" method="post" autocomplete="off" id="investments{{ $investment->id }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $investment->id }}">
                    <input type="hidden" name="userId" value="{{ $id }}">
                    <tr class="{{ 'Completed' === $investment->completed ? 'bg-greenLight' : 'return' }}">
                        <td>{{ $investment->id }}</td>
                        <td>{{ $investment['project']->name }}</td>
                        <td><input type="text" name="invested" value="{{ $investment->invested }}" /></td>
                        <td><input type="text" name="fts" value="{{ $investment->fts }}" /></td>
                        <td>{{ $investment['project']->profit }}</td>
                        <td>{{ $investment['project']->deadline }}</td>
                        <td><input type="text" name="notes" value="{{ $investment->notes }}" /></td>
                        @if('Completed' === $investment->completed)
                            <td></td>
                            <td class="text-center"><a class="text-secondary" href="#" onclick="returnInvestment({{ $investment->id }})">Return</a></td>
                        @else
                            <td><a class="color-blue" href="#" onclick="saveInvestment({{ $investment->id }})">Save</a></td>
                            <td><a class="text-success" href="#" onclick="completeInvestment({{ $investment->id }})">Complete</a></td>
                        @endif
                        <td><a class="text-danger" href="#" onclick="deleteInvestment({{ $investment->id }})">Delete</a></td>
                    </tr>
                </form>
            @endif
            @endforeach
        </tbody>
    </table>

    <hr class="my-5">

    <div class="row">
        <a href="#collapse_logs"><h2>Logs</h2></a>
        <div class="" id="collapse_logs">
            <table id="table2" class="table table-bordered table-hover table-cursor-pointer">
                <thead>
                    <tr>
                        <th>Log ID</th>
                        <th>User ID</th>
                        <th>User type</th>
                        <th>User name</th>
                        <th>Action</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @if($logs)
                        @foreach($logs as $log)
                            <tr>
                                <td>{{ $log->id }}</td>
                                <td>{{ $log->user_id }}</td>
                                <td>{{ $log->user_type }}</td>
                                <td>{{ $log->user_name }}</td>
                                <td>{{ $log->action }}</td>
                                <td>{{ $log->date }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <th>Log ID</th>
                        <th>User ID</th>
                        <th>User type</th>
                        <th>User name</th>
                        <th>Action</th>
                        <th>Date</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap5.min.css') }}">
@endpush
@push('scripts')
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script type="text/javascript">
function saveInvestment(id) {
    $("#investments"+id).submit();
}
function completeInvestment(id) {
    if (confirm("Are you sure to complete this investment?")) {
        window.location.href = '/user/investments/complete/'+id;
    }
}
function returnInvestment(id) {
    if (confirm("Are you sure to return this investment?")) {
        window.location.href = '/user/investments/complete/'+id;
    }
}
function deleteInvestment(id) {
    if (confirm("Are you sure to delete this investment?")) {
        window.location.href = '/user/investments/delete/'+id;
    }
}
function approveUser(id) {
    if (confirm("Are you sure to approve this user?")) {
        window.location.href = '/user/approve/'+id;
    }
}
function disapproveUser(id) {
    if (confirm("Are you sure to disapprove this user?")) {
        window.location.href = '/user/approve/'+id;
    }
}
function activateAttention(id) {
    if (confirm("Are you sure to activate attention on this user?")) {
        window.location.href = '/user/attention/'+id;
    }
}
function disActivateAttention(id) {
    if (confirm("Are you sure to dis activate attention on this user?")) {
        window.location.href = '/user/attention/'+id;
    }
}
function verifyUser(id) {
    if (confirm("Are you sure to verify on this user?")) {
        window.location.href = '/user/verify/'+id;
    }
}
function unVerifyUser(id) {
    if (confirm("Are you sure to non-verify on this user?")) {
        window.location.href = '/user/verify/'+id;
    }
}
function deleteUser(id) {
    if (confirm("Are you sure to delete this user?")) {
        window.location.href = '/user/delete/'+id;
    }
}
function deleteFile(id) {
    if (confirm("Are you sure to delete this file?")) {
        window.location.href = '/delete/'+id;
    }
}
$().ready(function(){
    $("#table2").DataTable({
        serverSide: false,
        responsive: true,
        autoWidth: false,
        "order": [[ 0, "desc" ]]
    });
    //setTimeout(function(){ $("#collapse_logs").addClass('collapse'); }, 100);
});
</script>
@endpush
@endsection
