@extends('layouts.admin')

@section('content')
        <div class="mb-5 d-flex justify-content-between">
            <h5>Today's Visitor Logs:</h5>
        </div>

        <div class="mb-5">
        @if($visitor_log->isEmpty())
            <h3>No Visitors Today</h3>
        @else
        <table class="table">
        <thead>
            <tr>
            <th>Name</th>
            <th>Phone Number</th>
            <th>ID Number</th>
            <th>Destination</th>
            <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach($visitor_log as $v)
            <tr class="table-primary">
                <td>{{ $v->first_name }} {{ $v->last_name }}</td>
                <td>{{ $v->phone_number }}</td>
                <td>{{ $v->id_number }}</td>
                <td>{{ $v->destination }}</td>
                <td>
                    <a href="{{ route('visitorInfo',$v->id) }}" class="btn btn-info">More Info</a> 
                </td>
            </tr>
        @endforeach
        </tbody>
        </table>
        @endif
        </div>
@endsection
