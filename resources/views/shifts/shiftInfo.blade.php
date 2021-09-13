@extends('layouts.admin')

@section('content')
        <div class="d-flex justify-content-between">
        {{__('Shift Info Of:')}}
        {{ $guard->firstname }} {{ $guard->lastname }}
                            <br />
                            <br />
        
            <div class="my-3 ml-3">
                <button class="btn btn-primary">
                    <a href="{{ route('shifts') }} " style="text-decoration:none; color:#fff">Back To Reports</a>
                </button>
            </div>
        </div>
                <table class="table mb-3">
                <thead>
                    <tr>
                    <th>Date</th>
                    <th>Clock In</th>
                    <th>Clock Out</th>
                    <th>Shift Duration</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($guard_details as $gd)
                        <tr class="table-primary">
                            <td>{{ $gd->created_at->toDateString() }}</td>
                            <td>{{ $gd->clockin }}</td>
                            <td>{{ $gd->clockout }}</td>
                            <td>{{ $gd->shift_duration }}</td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
                {{ $guard_details->links() }}

@endsection
