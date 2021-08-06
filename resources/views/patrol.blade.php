@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between"><span>{{ __('Dashboard') }}</span>  <span>{{ \Carbon\Carbon::now()->toDateString() }}</span></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(!empty($success))
                        <div class="alert alert-success"> {{ $success }}</div>
                    @endif

                    {{__('Hello')}}
                    {{ Auth::user()->name }}
                    <br />
                    <br />
                    {{ __('You are logged in!') }}
                </div> 

                @if(Auth::check() && Auth::user()->role === 'guard')
                <div class="my-3 ml-3">
                    <h5>Perform Patrol Scan</h5>
                    <button class="btn btn-secondary">
                        <a href="{{ route('scan') }} " style="text-decoration:none; color:#fff">Scan</a>
                    </button>
                </div>
                @endif

                @if (Auth::check() && Auth::user()->role === 'admin')
                <div class="my-3 ml-3">
                    <button class="btn btn-secondary">
                        <a href="{{ route('scan') }} " style="text-decoration:none; color:#fff">Reports</a>
                    </button>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
