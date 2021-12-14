@extends('layouts.admin')

@section('content')
<div class="content">
      <h2 class="content-title">
        {{ __('Visitor Information Number:') }} {{ $visitor_log->id }}
      </h2>
      <div>
        <span class="text-muted">
          <i class="fa fa-clock-o mr-5" aria-hidden="true"></i> {{ ($visitor_log->created_at)->format('H:i:s') }} <!-- mr-5 = margin-right: 0.5rem (5px) -->
        </span>
      </div>
      <div class="my-5 p-5">
        <h5>Details</h5>
        <p>Visitor by the name {{ $visitor_log->first_name }} {{ $visitor_log->last_name }} came by to see {{ $visitor_log->host}}
            at the location {{ $visitor_log->destination }}.
        </p>
        <p>ID Number: {{ $visitor_log->id_number }}</p>
        <p>Phone Number: {{ $visitor_log->phone_number }}</p>
      </div>
    </div>
    <hr />
    <!-- Second content container nested inside card (comments) -->
    <div>
      <div class="text-center mt-20"> <!-- text-center = text-align: center, mt-20 = margin-top: 2rem (20px) -->
        <button class="btn btn-primary">
            <a href=" {{ route('visitors') }} " style="text-decoration:none; color:#fff">Back</a>
        </button>
      </div>
    </div>
@endsection
