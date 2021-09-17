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
                    <table class="table table-hover">
                            <thead>
                                <tr>
                                <th scope="col" class="text-center">Sector</th>
                                <th scope="col" class="text-center">Total Scanned Times</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($collection->countBy() as $key => $c)
                                    <tr>
                                        <td class="text-center">{{ $key }}</td>
                                        <td class="text-center">{{ $c }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
