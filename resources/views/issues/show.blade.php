@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between"><span>{{ __('Tudor') }}</span>  <span>{{ \Carbon\Carbon::now()->toDateString() }}</span></div>

                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        {{__('Hello')}}
                        {{ Auth::user()->firstname }}.
                        <br />
                        <br />
                    </div>
                    <h3>{{ __('Issue Number:') }} {{ $issue->id }}</h3>
                    <h4>Title: {{ $issue->title }}</h3>
                    <h4>Location: {{ $issue->issueLocation }}</h5>
                    <h4>Created At: {{ $issue->created_at }}</h5>
                    <p>{{ $issue->details }}</p>

                    <button class="btn btn-success sm">
                        <a href=" {{ route('clearIssue', $issue->id) }} " style="text-decoration:none; color:#fff">Clear The Issue</a>
                    </button>
                </div> 

                <div class="my-3 ml-3">
                    <button class="btn btn-secondary">
                        <a href="{{ route('home') }} " style="text-decoration:none; color:#fff">Back To Dashboard</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
