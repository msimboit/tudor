@extends('layouts.admin')

@section('content')
        <div class="d-flex justify-content-between">
        {{__('Shifts conducted between the last 7 Days:')}}
                            <br />
                            <br />

            <div class="my-3 ml-3">
                <button class="btn btn-primary">
                    <a href="{{ route('guardShiftexport') }} " style="text-decoration:none; color:#fff">Get Reports</a>
                </button>
            </div>
        
            <div class="my-3 ml-3">
                <button class="btn btn-primary">
                    <a href="{{ route('shifts') }} " style="text-decoration:none; color:#fff">Back To Reports</a>
                </button>
            </div>
        </div>
                <div class="mb-5">
                    <table class="table mb-3">
                    <thead>
                        <tr>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Clock In</th>
                        <th>Clock Out</th>
                        <th>Shift Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shifts as $shift)
                            <tr class="table-primary">
                                <td>{{ $shift->first_name }}</td>
                                <td>{{ $shift->phone_number }}</td>
                                <td>{{ $shift->clockin }}</td>
                                <td>{{ $shift->clockout }}</td>
                                <td>{{ $shift->shift_duration }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>

@endsection
