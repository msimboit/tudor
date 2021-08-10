@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-16">
            <div class="card">
                <div class="card-header d-flex justify-content-between"><span>{{ Auth::user()->name }}</span>  <span>{{ \Carbon\Carbon::now()->toDateString() }}</span></div>

                <div class="card-body">
                    {{__('Shift Info of: ')}}
                    {{ $guard->firstname }}
                    <br />
                    <br />

                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Clock In</th>
                            <th scope="col">Clock Out</th>
                            <th scope="col">Shift Duration</th>
                            <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($guard_details as $gd)
                                <tr>
                                    <td>{{ $gd->created_at->toDateString() }}</td>
                                    <td>{{ $gd->clockin }}</td>
                                    <td>{{ $gd->clockout }}</td>
                                    <td>{{ $gd->shift_duration }}</td>
                                </tr>
                            @endforeach
                            {{ $guard_details->links() }}
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
