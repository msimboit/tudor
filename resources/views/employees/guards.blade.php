@extends('layouts.admin')

@section('content')
        <div class="d-flex justify-content-between">
        {{__('All Registered Guards:')}}
                            <br />
                            <br />
        
            <div class="mt-2 p-2">
                <button class="btn btn-primary">
                    <a href="{{ route('home') }} " style="text-decoration:none; color:#fff">Back To Dashboard</a>
                </button>
            </div>
        </div>
                <table class="table mb-3">
                <thead>
                    <tr>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($guards as $guard)
                        <tr class="table-primary">
                            <td>{{ $guard->firstname }} {{ $guard->lastname }}</td>
                            <td>{{ $guard->phone_number }}</td>
                            <td>{{ $guard->email }}</td>
                            <!-- <td>
                                <a href="{{ route('shiftInfo',$guard->id) }}" class="btn btn-info">Info</a> 
                            </td> -->
                        </tr>
                    @endforeach
                </tbody>
                </table>
@endsection
