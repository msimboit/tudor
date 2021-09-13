@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between"><span>{{ __('Report An Issue') }}</span>  <span>{{ \Carbon\Carbon::now()->toDateString() }}</span></div>

                <div class="card-body">
                    {{__('Hello')}}
                    {{ Auth::user()->firstname }}
                    <br />
                    <br />
                    {{ __('Report Your Issue Below:') }}
                    <br />
                    <br />
                    
                    <form action="{{ route('storeIssue') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @if ($errors->any())
                        <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        </div>
                        @endif

                        <div class="form-group">
                            <label for="title">Issue Title:</label>
                            <input type="text" name="title" value="{{ old('title') }}" class="form-control" placeholder="Title" required>
                        </div>

                        <div class="form-group">
                            <label for="issueLocation">Issue Location: (or closest)</label>
                            <select class="form-control col-md-4" name="issueLocation" required>
                                <option>Select Location</option>
                                @foreach ($sectors as $sector)
                                <option value="{{ $sector->name }}" > 
                                    {{ $sector->name }} 
                                </option>
                                @endforeach    
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="details">Issue details:</label>
                            <textarea name="details" value="{{ old('details') }}" class="form-control" placeholder="Details" required></textarea>
                        </div>

                        <div class="form-group">
                            <input type="submit" value="{{ __('Report Issue') }}" class="btn btn-success">
                        </div>

                    </form>

                    <div class="my-3">
                        <button class="btn btn-secondary">
                            <a href="{{ route('home') }} " style="text-decoration:none; color:#fff">Go Back</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
