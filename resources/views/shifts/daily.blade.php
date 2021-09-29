@extends('layouts.admin')

@section('content')
        <div class="mb-5 d-flex justify-content-between">
            <h5>Today's Scans:</h5>

            <form action="{{ route('locationFilter') }}" method="POST">
                        @csrf
                        <div class="d-flex justify-content-between">
                            <div class="d-flex justify-content-between">
                                <div class="input-group-prepend">
                                <span class="input-group-text">Location</span>
                                </div>
                                <select class="form-control" id="select-3" name="location">
                                    <option value="" selected="selected" disabled="disabled">Select a location</option>
                                    <option value="langata">Lang'ata</option>
                                    <option value="baraka">Baraka</option>
                                    <option value="allimex">Allimex Plaza</option>
                                </select>
                            </div>
                            <button class="btn btn-success ml-3" type="submit">Search</button>
                        </div>
                        
                    </form>
        </div>

        <div class="mb-5">
        @if($scanned_areas->isEmpty())
            <h3>No Scans Today</h3>
        @else
        <table class="table">
        <thead>
            <tr>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Scan</th>
            <th>Time</th>
            </tr>
        </thead>
        <tbody>
        @foreach($scanned_areas as $s)
            <tr class="table-primary">
                <td>{{ $s->first_name }}</td>
                <td>{{ $s->phone_number }}</td>
                <td>{{ $s->sector_name}}</td>
                <td>{{ $s->time}}</td>
                <!-- @php
                $area = substr($s->sector, 0, 6);
                if($area == 'TCS000')
                {
                    echo "<td>Lang'ata</td>";
                }
                elseif((substr($s->sector, 0, 3)) == 'ALP'){
                    echo "<td>Allimex</td>";
                }
                else{
                    echo "<td>Baraka</td>";
                }
                @endphp -->
            </tr>
        @endforeach
        </tbody>
        </table>
        @endif
        </div>
@endsection
