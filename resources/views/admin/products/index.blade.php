@extends('layouts.admin')

@section('main')
    <div class="row">
        <div class="col-sm-12">
            <h1 class="display-3">Products</h1>
            <table class="table table-striped table-sm">
                <thead>
                <div>
                    <a style="margin: 19px;" href="{{ route('admin.products.create')}}" class="btn btn-primary">New product</a>
                </div>
                <tr class="text-primary text-uppercase">
                    <td>ID</td>
                    <td>Sku</td>
                    <td>Name</td>
                    <td>Description</td>
                    <td>Image</td>
                    <td>Price</td>
                    <td>Stock</td>
                    <td>Enabled</td>
                    <td>Notes</td>
                    <td>Actions</td>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td><img src="{{ $product->image }}" style="width:100px" alt="{{ $product->name }}"></td>
                        <td>${{ $product->price }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->enabled }}</td>
                        <td>{{ $product->notes }}</td>
                        <td class="row">
                            <a href="{{ route('admin.products.edit',$product->id)}}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                {{ $products->render() }}
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
