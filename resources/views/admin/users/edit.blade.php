@extends('layouts.admin')

@section('main')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h1 class="display-3">Update a user</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <br/>
            @endif
            <form method="post" action="{{ route('admin.users.update', $user->id) }}">
                @method('PATCH')
                @csrf
                <div class="form-group">
                    <label for="name" class="col-form-label-lg">{{__('Name:')}}</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                           name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

                    @error('name')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email" class="col-form-label-lg">{{__('Email:')}}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ $user->email }}" required autocomplete="email">

                    @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password" class="col-form-label-lg">{{ __('Password:') }}</label>
                    <input id="password" type="password"
                           class="form-control @error('password') is-invalid @enderror" name="password"
                           autocomplete="new-password"/>

                    @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="form-group col">
                        <label for="roles" class="col-form-label-lg">{{ __('Roles:') }}</label>
                        <div>
                            @foreach($roles as $role)
                                <div class="form-check">
                                    <label>{{ $role->name }}</label>
                                    <input type="radio" name="roles" value="{{ $role->id }}"
                                            @if ($role->id == $user->role_id)
                                                checked
                                            @endif>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group col">
                            <label for="is_enabled">{{ __('Enabled') }}</label>
                            <input id="is_enabled" type="checkbox" name="is_enabled"
                                   @if ($user->is_enabled) checked @endif>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
