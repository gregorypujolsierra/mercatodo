@extends('layouts.admin')

@section('main')
    <div class="row">
        <div class="col-sm-12">
            <h1 class="display-3">Users</h1>
            <table class="table table-striped table-sm">
                <thead>
                <div>
                    <a style="margin: 19px;" href="{{ route('admin.users.create')}}" class="btn btn-primary">New user</a>
                </div>
                <tr class="text-primary text-uppercase">
                    <td>ID</td>
                    <td>Name</td>
                    <td>Email</td>
                    <td>Roles</td>
                    <td>Enabled</td>
                    <td>Actions</td>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role->name ?? '- unset -' }}</td>
                        <td>{{$user->is_enabled}}</td>
                        <td class="row">
                            <a href="{{ route('admin.users.edit',$user->id)}}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('admin.users.destroy', $user->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        <div>
    </div>
    <div class="col-sm-12">
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @elseif(session()->get('warning'))
            <div class="alert alert-warning">
                {{ session()->get('warning') }}
            </div>
        @elseif(session()->get('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif
    </div>
@endsection
