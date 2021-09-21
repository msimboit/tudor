@extends('layouts.admin')

@section('content')
        <div class="d-flex justify-content-between">
        {{__('All Registered Clients:')}}
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
                    @foreach($clients as $client)
                        <tr class="table-primary">
                            <td>{{ $client->firstname }} {{ $client->lastname }}</td>
                            <td>{{ $client->phone_number }}</td>
                            <td>{{ $client->email }}</td>
                            <!-- <td>
                                <a href="{{ route('shiftInfo',$client->id) }}" class="btn btn-info">Info</a> 
                            </td> -->
                        </tr>
                    @endforeach
                </tbody>
                </table>
@endsection
