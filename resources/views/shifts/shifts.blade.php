@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between"><span>{{ __('Guards') }}</span>  <span>{{ \Carbon\Carbon::now()->toDateString() }}</span></div>

                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        {{__('Hello')}}
                        {{ Auth::user()->firstname }}.
                        <br />
                        <br />

                        <button class="btn btn-secondary btn-sm">
                            <a href="{{ route('shiftExport') }} " style="text-decoration:none; color:#fff">Generate Excel Sheet</a>
                        </button>

                    </div>

                    <div class="my-3">
                    <form action="{{ route('shiftSearch') }}" method="POST">
                        @csrf
                        <div class="">
                            <label for="from">From:</label>
                            <input type="date" id="from" name="from">

                            <label for="to" class="ml-3">To:</label>
                            <input type="date" id="to" name="to">
                            <button class="btn btn-success ml-3" type="submit">Search</button>
                        </div>
                        
                    </form>

                    </div>

                    {{__('All Registered Guards:')}}
                    <br />
                    <br />
                    <table class="table-responsive table-hover">
                        <thead>
                            <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($guards as $guard)
                                <tr>
                                    <td>{{ $guard->id_number }}</td>
                                    <td>{{ $guard->firstname }}</td>
                                    <td>{{ $guard->email }}</td>
                                    <td>{{ $guard->role }}</td>
                                    <td>
                                        <a href="{{ route('shiftInfo',$guard->id) }}" class="btn btn-info">Info</a> 
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> 

                <div class="my-3 ml-3">
                    <button class="btn btn-secondary">
                        <a href="{{ route('home') }} " style="text-decoration:none; color:#fff">Back To Dashboard</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
