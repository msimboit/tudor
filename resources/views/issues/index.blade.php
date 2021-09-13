@extends('layouts.admin')

@section('content')
        <div class="d-flex justify-content-between">
        {{__('All Raised Issues:')}}
                            <br />
                            <br />
        
            <div class="mt-2 p-2">
                <button class="btn btn-primary">
                    <a href="{{ route('home') }} " style="text-decoration:none; color:#fff">Back To Dashboard</a>
                </button>
            </div>
        </div>
                @if($issues->isEmpty())
                    <h3>No Issues Found</h3>
                @else
                <table class="table mb-3">
                <thead>
                    <tr>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Issue Title</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($issues as $issue)
                        <tr class="table-primary">
                            <td>{{ $issue->first_name }}</td>
                            <td>{{ $issue->phone_number }}</td>
                            <td>{{ $issue->title }}</td>
                            <td>
                                <a href="{{ route('issueInfo', $issue->id) }}" class="btn btn-primary">More Info</a> 
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
                @endif
@endsection
