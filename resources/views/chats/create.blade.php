@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between"><span>{{ __('Chatroom') }}</span>  <span>{{ \Carbon\Carbon::now()->toDateString() }}</span></div>

                <div class="card-body">
                    {{__('Hello')}}
                    {{ Auth::user()->firstname }}
                    <br />
                    <br />
                    {{__('Chatting with:')}}
                    {{ $chatWith->firstname }}
                    <br />
                    <br />

                    <!-- @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                    @endif -->

                    <div class="table-responsive">
                    <table class="table">
                        <thead>
                          
                        </thead>
                        <tbody class="overflow-auto">
                            @foreach($chats as $chat)
                                <tr>
                                    <td>{{$chat->sender_email}}</td>
                                    <td>{{ $chat->message }}</td>
                                    <!-- <td>{{ (Carbon\Carbon::parse($chat->created_at))->format('M d') }}</td> -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>

                    <!-- <div class="overflow-auto">
                        @foreach($chats as $chat)
                        <div>{{ $chat->sender_email }} {{ $chat->message}}</div>
                        @endforeach
                    </div> -->
                    <form action="{{ route('chatStore') }}" method="POST" enctype="multipart/form-data">
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
                            <!-- <label for="details">Message:</label> -->
                            <textarea name="message" value="{{ old('message') }}" class="form-control" placeholder="Type your message here" row="1"></textarea>
                        </div>
                        <input type="text" name="receiver_email" value="{{$chatWith->email}}" hidden>

                        <div class="form-group">
                            <input type="submit" value="{{ __('Send') }}" class="btn btn-success btn-sm float-right">
                        </div>

                    </form>
                </div>

                <div class="my-3">
                        <button class="btn btn-secondary">
                            <a href="{{ route('chats', Auth::user()->id) }} " style="text-decoration:none; color:#fff">Go Back</a>
                        </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
