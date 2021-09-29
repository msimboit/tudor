@extends('layouts.admin')

@section('content')
        <div class="mb-5">
            <h5>Today's Scans:</h5>
            <p>For the location of: {{$location}}</p>
        </div>

        <div class="mb-5">
        @if($scanned_areas->isEmpty())
            <h3>No Scans Today</h3>
        @else
        <table class="table">
        <thead>
            <tr>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Scan</th>
            <th>Time</th>
            </tr>
        </thead>
        <tbody>
        @foreach($scanned_areas as $s)
            <tr class="table-primary">
                <td>{{ $s->first_name }}</td>
                <td>{{ $s->phone_number }}</td>
                <td>{{ $s->sector_name}}</td>
                <td>{{ $s->time}}</td>
            </tr>
        @endforeach
        </tbody>
        </table>
        @endif
        </div>
@endsection
