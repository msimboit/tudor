@extends('layouts.admin')

@section('content')
        <div class="mb-5">
            <h5>Today's Scans:</h5>
            <p>For the location of: {{$location}}</p>

            <div class="my-3 ml-3">
                <button class="btn btn-primary">
                    <a href="{{ route('dailyGuardShiftexport', ['location'=>$location]) }} " style="text-decoration:none; color:#fff">Get Today's Reports</a>
                </button>
            </div>
        </div>

        <div class="mb-5">
            <h5>Get reports for a specific date range:</h5>
                    <form action="{{ route('specificDateReport') }}" method="POST">
                        @csrf
                        <div class="d-flex justify-content-between">
                            <div class="d-flex justify-content-between">
                                <div class="input-group-prepend">
                                <span class="input-group-text">From</span>
                                </div>
                                <input type="date" class="form-control" id="from" name="from">
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <div class="input-group-prepend">
                                <span class="input-group-text">To</span>
                                </div>
                                <input type="date" class="form-control" id="to" name="to">
                            </div>
                            <input type="hidden" name="location" value={{$location}}>
                            <button class="btn btn-success ml-3" type="submit">Get Report</button>
                        </div>
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
