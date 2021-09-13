@extends('layouts.admin')

@section('content')

                <div class="mb-5">
                    <form action="{{ route('shiftSearch') }}" method="POST">
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

                            <div class="d-flex justify-content-between">
                                <div class="input-group-prepend">
                                <span class="input-group-text">Role</span>
                                </div>
                                <select class="form-control" id="select-3" name="role">
                                    <option value="" selected="selected" disabled="disabled">Select a role</option>
                                    <option value="all">All Roles</option>
                                    <option value="management">Management</option>
                                    <option value="operations">Operations</option>
                                    <option value="control room">Control Room</option>
                                    <option value="production">Production</option>
                                    <option value="guard">Guard</option>

                                </select>
                            </div>

                            <!-- <label for="role" class="ml-3">Role:</label>
                            <select name="role" id="role" required>
                                    <option value="all">All Roles</option>
                                    <option value="management">Management</option>
                                    <option value="operations">Operations</option>
                                    <option value="control room">Control Room</option>
                                    <option value="production">Production</option>
                                    <option value="guard">Guard</option>
                            </select> -->
                            
                            <button class="btn btn-success ml-3" type="submit">Search</button>
                        </div>
                        
                    </form>

                </div>
                <!-- <div class="my-5">
        {{__('Check on specific employee shift:')}}
        </div> -->

        <div class="mb-5">
        <table class="table">
        <thead>
            <tr>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Role</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr class="table-primary">
                <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                <td>{{ $user->phone_number }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <a href="{{ route('shiftInfo',$user->id) }}" class="btn btn-primary">Info</a> 
                </td>
            </tr>
        @endforeach
        </tbody>
        </table>
        </div>
        {{ $users->links() }}
@endsection
