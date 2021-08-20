@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between"><span>{{ __('Tudor') }}</span>  <span>{{ \Carbon\Carbon::now()->toDateString() }}</span></div>

                <div class="card-body">
                    @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                    @endif

                    <div class="d-flex justify-content-between">
                        {{__('Hello')}}
                        {{ Auth::user()->firstname }}.
                        <br />
                        <br />
                    </div>

                    {{__('All Raised Issues are:')}}
                    <br />
                    <br />
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Issue Title</th>
                            <th scope="col">Issue Location</th>
                            <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($issues as $issue)
                                <tr>
                                    <td>{{ $issue->first_name }}</td>
                                    <td>{{ $issue->phone_number }}</td>
                                    <td>{{ $issue->title }}</td>
                                    <td>{{ $issue->issueLocation }}</td>
                                    <td>
                                        <a href="{{ route('issueInfo', $issue->id) }}" class="btn btn-info">More Info</a> 
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
