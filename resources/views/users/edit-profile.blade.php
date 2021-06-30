@extends('layouts.app')

@section('content')  
    <div class="card mt-5">
        <div class="card-header">{{ __('My Profile') }}</div>
        <div class="card-body">
            @include('partials.errors')
            <form method="POST" action="{{ route('users.update-profile') }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name" class="col-form-label">{{ __('Name') }}</label>

                    <input id="name" value="{{$user->name}}" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert" value="{{$user->about}}">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>

                <div class="form-group">
                    <label for="about">About</label>
                    <textarea name="about" class="form-control" id="about" cols="3" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        {{ __('Update Profile') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
