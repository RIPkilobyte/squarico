@extends('app')
@section('content')

@include('header1')


<div class="container my-5">

    @include('errors')

    <h1 class="title">Project edit</h1>

    <form action="{{ route('project', $id) }}" method="post" autocomplete="off">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <p class="fw-bold mt-3">Name</p>
                <div class="form-floating">
                    @php($projectValue = '')
                    @if ($id)
                    @php($projectValue = $project->name)
                    @endif
                    @php($valueName = old('name') ?? $projectValue)
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="floatingName" placeholder="Name" value="{{ $valueName }}">
                    <label for="floatingName">Name</label>
                </div>
                <p class="fw-bold mt-3">Project description</p>
                <div class="form-floating">
                    @php($projectValue = '')
                    @if ($id)
                    @php($projectValue = $project->description)
                    @endif
                    @php($valueDescription = old('description') ?? $projectValue)
                    <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" id="floatingDescription" placeholder="Project description" value="{{ $valueDescription }}">
                    <label for="floatingDescription">Project description</label>
                </div>
                <p class="fw-bold mt-3">Link</p>
                <div class="form-floating">
                    @php($projectValue = '')
                    @if ($id)
                    @php($projectValue = $project->link)
                    @endif
                    @php($valueLink = old('link') ?? $projectValue)
                    <input type="text" name="link" class="form-control @error('link') is-invalid @enderror" id="floatingLink" placeholder="Link" value="{{ $valueLink }}">
                    <label for="floatingLink">Link</label>
                </div>
                <p class="fw-bold mt-3">Life project update link</p>
                <div class="form-floating">
                    @php($projectValue = '')
                    @if ($id)
                    @php($projectValue = $project->update_link)
                    @endif
                    @php($valueUpdateLink = old('updateLink') ?? $projectValue)
                    <input type="text" name="updateLink" class="form-control @error('updateLink') is-invalid @enderror" id="floatingUpdateLink" placeholder="Life project update link" value="{{ $valueUpdateLink }}">
                    <label for="floatingUpdateLink">Life project update link</label>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <p class="fw-bold mt-3">Start date</p>
                        <div class="form-floating">
                            @php($projectValue = '')
                            @if ($id)
                                @php($projectValue = $project->start_at)
                            @endif
                            @php($valueStartAt = old('startAt') ?? $projectValue)
                            <input type="date" name="startAt" class="form-control @error('startAt') is-invalid @enderror" id="floatingStartAt" placeholder="Start date" value="{{ $valueStartAt }}">
                            <label for="floatingStartAt">Start date</label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <p class="fw-bold mt-3">Deadline</p>
                        <div class="form-floating">
                            @php($projectValue = '')
                            @if ($id)
                                @php($projectValue = $project->deadline)
                            @endif
                            @php($valueDeadline = old('deadline') ?? $projectValue)
                            <input type="date" name="deadline" class="form-control @error('deadline') is-invalid @enderror" id="floatingDeadline" placeholder="Deadline" value="{{ $valueDeadline }}">
                            <label for="floatingDeadline">Deadline</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    @php($text = $id ? 'Update' : 'Create')
                    <div class="col-lg-6">
                        <button class="w-100 btn btn-lg btn-blue" type="submit">{{ $text }}</button>
                    </div>
                    @if ($id)
                        <div class="col-lg-6">
                            <a class="w-100 btn btn-lg btn-red" onclick="return confirm('Are you sure to delete this project?')" href="{{ route('project.delete', $id) }}">Delete</a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-6 ps-xxl-5">
                <p class="fw-bold mt-3">Expectations description</p>
                <div class="form-floating pb-1">
                    @php($projectValue = '')
                    @if ($id)
                    @php($projectValue = $project->expectations_description)
                    @endif
                    @php($valueExpectationsDescription = old('expectationsDescription') ?? $projectValue)
                    <textarea name="expectationsDescription" rows="6" style="height:100%;" class="form-control @error('expectationsDescription') is-invalid @enderror" placeholder="Expectations description" id="floatingExpectationsDescription">{{ $valueExpectationsDescription }}</textarea>
                    <label for="floatingExpectationsDescription">Expectations description</label>
                </div>
                <p class="fw-bold mt-3">Profit description</p>
                <div class="form-floating">
                    @php($projectValue = '')
                    @if ($id)
                    @php($projectValue = $project->profit_description)
                    @endif
                    @php($valueProfitDescription = old('profitDescription') ?? $projectValue)
                    <textarea name="profitDescription" rows="6" style="height:100%;" class="form-control @error('profitDescription') is-invalid @enderror" placeholder="Profit description" id="floatingProfitDescription">{{ $valueProfitDescription }}</textarea>
                    <label for="floatingProfitDescription">Profit description</label>
                </div>
                <div class="row pt-1">
                    <div class="col-lg-4">
                        <p class="fw-bold mt-3">Sq. fts</p>
                        <div class="form-floating">
                            @php($projectValue = '')
                            @if ($id)
                                @php($projectValue = $project->fts)
                            @endif
                            @php($valueFts = old('fts') ?? $projectValue)
                            <input type="text" name="fts" class="form-control @error('fts') is-invalid @enderror" id="floatingFts" placeholder="Sq. fts" value="{{ $valueFts }}">
                            <label for="floatingFts">Sq. fts</label>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <p class="fw-bold mt-3">Price, £</p>
                        <div class="form-floating">
                            @php($projectValue = '')
                            @if ($id)
                                @php($projectValue = $project->price)
                            @endif
                            @php($valuePrice = old('price') ?? $projectValue)
                            <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" id="floatingPrice" placeholder="Price" value="{{ $valuePrice }}">
                            <label for="floatingPrice">Price</label>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <p class="fw-bold mt-3">Exp. profit, %</p>
                        <div class="form-floating">
                            @php($projectValue = '')
                            @if ($id)
                                @php($projectValue = $project->profit)
                            @endif
                            @php($valueProfit = old('profit') ?? $projectValue)
                            <input type="text" name="profit" class="form-control @error('profit') is-invalid @enderror" id="floatingProfit" placeholder="Exp. profit, %" value="{{ $valueProfit }}">
                            <label for="floatingProfit">Exp. profit , %</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @if($id)
        <hr class="my-5">

        <h2 class="title">Files</h2>
        @foreach($files as $file)
            <div class="row my-4">
                <div class="col-xl-6">
                    <div class="row">
                        <div class="col-1">
                            <div class="investmens__file mb-2"></div>
                        </div>
                        <div class="col-9">
                            <a href="{{ route('download', $file->id) }}">{{ $file->name }}</a>
                        </div>
                        <div class="col-2 text-end">
                            <a class="text-danger" onclick="return confirm('Are you sure to delete this file?')" href="{{ route('delete', $file->id) }}">X</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <form action="{{ route('upload') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $id }}">
            <input type="hidden" name="entity" value="project">
            <div class="row my-3 align-items-center">
                <div class="col-md-2">
                    <input type="text" name="fileName" class="form-control" placeholder="File name" />
                </div>
                <div class="col-md-3">
                    <input class="form-control" type="file" name="file" id="floatingFile" />
                </div>
                <div class="col-md-2">
                    <button class="d-block btn btn-lg btn-blue px-5" type="submit">Upload</button>
                </div>
            </div>
        </form>

        <hr class="my-5">

        <div class="border border-primary border-2 my-3 p-3">
            <div class="row mb-3">
                <div class="col-lg-9">
                    <div class="investmens__name"><span>{{ $project->name }}</span>{{ $project->description }}</div>
                </div>
                <div class="col-lg-3 text-lg-end">
                    <b>Expected exit in {{ round((strtotime($project->deadline) - time())/(60*60*24)) }} days</b>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <img width="100%" src="{{ asset('img/example.png') }}">
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-4">
                            {{ $project->expectations_description }}
                        </div>
                        <div class="col-lg-4">
                            {{ $project->profit_description }}
                        </div>
                        <div class="col-lg-4">
                            <a class="w-100 btn btn-theme btn-success" href="{{ $project->update_link }}" target="_blank">Life project update</a>
                        </div>
                    </div>
                    <div class="row my-4">
                        <div class="col-12">
                            <div class="d-flex flex-wrap">
                                @foreach($files as $file)
                                    <div class="investmens__file mb-2"><a href="{{ route('download', $file->id) }}">{{ $file->name }}</a></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @if(0 < $project->interval)
                        <div class="row">
                            <div class="col-12">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $project->interval }}%;" aria-valuenow="{{ $project->interval }}" aria-valuemin="0" aria-valuemax="100">{{ $project->interval }}%</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
    <link href="{{ asset('css/investments.css') }}" rel="stylesheet">
@endpush

@endsection
