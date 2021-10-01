@extends('layouts.admin')

@section('content')
<div class="content">
      <h2 class="content-title">
        {{ __('Issue Number:') }} {{ $issue->id }}
      </h2>
      <div>
        <span class="text-muted">
          <i class="fa fa-clock-o mr-5" aria-hidden="true"></i> {{ $issue->created_at }} <!-- mr-5 = margin-right: 0.5rem (5px) -->
        </span>
      </div>
      <div class="my-5 p-5">
        <h5>{{ $issue->details }}</h5>
      </div>

      @if($issue->image != null)
      <div class="my-5 p-5" style="width: 100px; height: 100px;">
        <img src="{{ asset('issues_images/' .$issue->image) }}" alt="Issue Image" class="img-fluid max-width: 100%; height: auto;">
      </div>
      @endif
    </div>
    <hr />
    <!-- Second content container nested inside card (comments) -->
    <div>
      <div class="text-center mt-20"> <!-- text-center = text-align: center, mt-20 = margin-top: 2rem (20px) -->
        <button class="btn btn-primary">
            <a href=" {{ route('clearIssue', $issue->id) }} " style="text-decoration:none; color:#fff">Clear The Issue</a>
        </button>
      </div>
    </div>
@endsection
