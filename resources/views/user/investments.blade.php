@extends('app')
@include('errors')
@section('content')

    @include('header1')

    <main class="container my-5">
        <h2 class="title mb-4">My investments</h2>

        @if($invested)

            <h3>Investment snapshot</h3>
            <div class="row mb-4">
                <div class="col-md-3"><span class="circleBlue"></span>Currently invested: £ {{ $summ }}</div>
                <div class="col-md-3"><span class="circleBlue"></span>No. of projects: {{ $countProjects }}</div>
                <div class="col-md-3"><span class="circleBlue"></span>Number of Sq.feet: {{ $feet }}</div>
                <div class="col-md-3"><span class="circleBlue"></span>Expected profit*: £ {{ $profit }}</div>
            </div>

            <h3>My projects list</h3>

            @foreach($investments as $investment)
                <div class="border border-primary border-2 my-3 p-3">
                    <div class="row mb-3">
                        <div class="col-lg-9">
                            <div class="investmens__name"><span>{{ $investment->project->name }}</span>{{ $investment->project->description }}</div>
                        </div>
                        <div class="col-lg-3 text-lg-end">
                            <b>Expected exit in {{ $investment->days }} days</b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <img width="100%" src="/img/example.png">
                        </div>
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="col-lg-4">
                                    {{ $investment->project->expectations_description }}
                                </div>
                                <div class="col-lg-4">
                                    {{ $investment->project->profit_description }}
                                </div>
                                <div class="col-lg-4">
                                    <a class="w-100 btn btn-theme btn-success" href="{{ $investment->project->update_link }}">Life project update</a>
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="col-12">
                                    <div class="d-flex flex-wrap">
                                        @foreach($investment->files as $file)
                                            <div class="investmens__file mb-2"><a href="{{ route('download', $file->id) }}">{{ $file->name }}</a></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @if(0 < $investment->interval)
                                <div class="row">
                                    <div class="col-12">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $investment->interval }}%;" aria-valuenow="{{ $investment->interval }}" aria-valuemin="0" aria-valuemax="100">{{ $investment->interval }}%</div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

        @else
            <p>You don’t have any investments currently</p>
        @endif
    </main>

@push('styles')
<link href="{{ asset('css/investments.css') }}" rel="stylesheet">
@endpush

@endsection
