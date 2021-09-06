@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between"><span>{{ __('Tudor') }}</span>  <span>{{ \Carbon\Carbon::now()->toDateString() }}</span></div>

                <div class="card-body">
                    @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                    @endif

                    <div class="d-flex justify-content-between">
                        {{__('Hello')}}
                        {{ Auth::user()->firstname }}.
                        <br />
                        <br />
                    </div>

                    {{__('Chatroom:')}}
                    <br />
                    <br />

                    <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">Name</th>
                            <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($all_users as $user)
                                <tr>
                                    <td>{{ $user->firstname }}</td>
                                    <td>
                                        <a href="{{ route('chat', $user->id) }}" class="btn btn-info">Chat</a> 
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
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
