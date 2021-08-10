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
                        {{ __('The following areas have been scanned recently:') }}
                        <br />
                        <br />
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                <th scope="col">Guard</th>
                                <th scope="col">Sector</th>
                                <th scope="col">Time Scanned</th>
                                <th scope="col">Date Scanned</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($scanned_areas as $scanned_area)
                                    <tr>
                                        <td>{{ $scanned_area->guard_name }}</td>
                                        <td>{{ $scanned_area->sector_name }}</td>
                                        <td>{{ $scanned_area->time }}</td>
                                        <td>{{ Carbon\Carbon::parse($scanned_area->created_at)->format('d-m-Y')}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $scanned_areas->links() }}

                    @else
                    <br />
                    <br />
                    <strong><p>No Areas Scanned!</p></strong>
                    @endif
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
