@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between"><span>{{ __('Dashboard') }}</span>  <span>{{ \Carbon\Carbon::now() }}</span></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{__('Hello')}}
                    {{ Auth::user()->firstname }}
                    <br />
                    <br />
                    {{ __('You are logged in!') }}
                </div> 

                @if(Auth::check() && Auth::user()->role === 'guard')
                <div class="my-3 ml-3">
                    <h5>Clock In For Duty</h5>
                    <button class="btn btn-secondary">
                        <a href="{{ route('clockin') }} " style="text-decoration:none; color:#fff">Clock In</a>
                    </button>
                </div>
                @endif

                @if (Auth::check() && Auth::user()->role === 'admin')
                <div class="my-3 ml-3">
                    <button class="btn btn-secondary">
                        <a href="{{ route('shifts') }} " style="text-decoration:none; color:#fff">Reports</a>
                    </button>
                </div>

                <div class="my-3 ml-3">
                    <button class="btn btn-secondary">
                        <a href="{{ route('registerUser') }} " style="text-decoration:none; color:#fff">Register User</a>
                    </button>
                </div>

                @endif

                @if (Auth::check() && Auth::user()->role !== 'admin' && Auth::user()->role !== 'guard')
                <div class="my-3 ml-3">
                    <h5>Clock In To Work</h5>
                    <button class="btn btn-secondary">
                        <a href="{{ route('clockin') }} " style="text-decoration:none; color:#fff">Clock In</a>
                    </button>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
