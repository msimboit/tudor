@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between"><span>{{ __('Scanned Areas') }}</span>  <span>{{ \Carbon\Carbon::now()->toDateString() }}</span></div>

                <div class="card-body">
                    {{__('Hello')}}
                    {{ Auth::user()->firstname }}
            
                    @if(!empty($scanned_areas[0]))
                    <br />
                    <br />
                    {{ __('You have scanned the following areas this shift:') }}
                    <br />
                    <br />
                    @foreach ($scanned_areas as $scanned_area)
                        <strong><p>{{ $scanned_area->sector_name }}</p></strong>
                    @endforeach
                    @else
                    <br />
                    <br />
                    <strong><p>No Areas Scanned!</p></strong>
                    @endif
                </div> 

                @if(Auth::check() && Auth::user()->role === 'guard')
                <div class="my-3 ml-3">
                    <h5>Back to patrol</h5>
                    <button class="btn btn-secondary">
                        <a href="{{ route('patrol') }} " style="text-decoration:none; color:#fff">Patrol</a>
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
