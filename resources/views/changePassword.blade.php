@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Change Your Password') }}</div>
                
                <div class="card-body">
                @if (Session::has('warning'))
                        <div class="alert alert-danger" role="alert">
                        {{ Session::get('warning') }}
                        </div>
                @endif
                    <form method="POST" action="{{ route('passwordChanged') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="oldPassword" class="col-md-4 col-form-label text-md-right">{{ __('Old Password') }}</label>

                            <div class="col-md-6">
                                <input id="oldPassword" type="text" class="form-control @error('firstname') is-invalid @enderror" name="oldPassword" value="{{ old('oldPassword') }}" required autocomplete="oldPassword" autofocus>

                                @error('oldPassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="newPassword" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>

                            <div class="col-md-6">
                                <input id="newPassword" type="password" class="form-control @error('newPassword') is-invalid @enderror" name="newPassword" value="{{ old('newPassword') }}" required autocomplete="lastname" autofocus>

                                @error('newPassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <input type="text" name="user" value="{{ $user->id }}" hidden>
                        <input type="text" name="userOldPassword" value="{{ $user->password }}" hidden>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Change Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
