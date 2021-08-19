@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-16">
            <div class="card">
                <div class="card-header d-flex justify-content-between"><span>{{ Auth::user()->firstname }}</span>  <span>{{ \Carbon\Carbon::now()->toDateString() }}</span></div>

                <div class="card-body">
                    {{__('Shift Search Results: ')}}
                    <br />
                    <br />


                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Clock In</th>
                            <th scope="col">Clock Out</th>
                            <th scope="col">Shift Duration</th>
                            <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shifts as $shift)
                                <tr>
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

                <div class="my-3 ml-3">
                    <button class="btn btn-secondary">
                        <a href="{{ route('shifts') }} " style="text-decoration:none; color:#fff">Back To Reports</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
