@extends('layouts.admin')

@section('main')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h1 class="display-3">Add a user</h1>
            <div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br/>
                @endif
                <form method="post" action="{{ route('users.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">{{__('Name:')}}</label>
                        <input id="name" type="text" class="form-control" name="name" required/>
                    </div>

                    <div class="form-group">
                        <label for="email">{{__('Email:')}}</label>
                        <input id="email" type="text" class="form-control" name="email" required/>
                    </div>
                    <div class="form-group">
                        <label for="password">{{ __('Password:') }}</label>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror" name="password" required
                               autocomplete="new-password"/>

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">{{__('Add user')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
