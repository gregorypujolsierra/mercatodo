@extends('layouts.admin')

@section('main')
    <div class="row">
        <div class="col-sm-12">
            <h1 class="display-3">Products</h1>
            <table class="table table-striped table-sm">
                <thead>
                <div class="navbar">
                    <div>
                        <a style="margin: 19px;" href="{{ route('admin.products.create')}}" class="btn btn-primary">New product</a>
                    </div>
                    <div class="form-inline float-right">
                        <form id="admin_product_search" action="{{ route('admin.products.index')}}" class="form-inline">
                            <div class="form-group">
                                <input type="number" id="min_price" name="min_price" style="width: 90px;"
                                       class="form-control p-1 m-1 @error('min_price') is-invalid @enderror"
                                       aria-label="Min price" placeholder="Min price" min="0"
                                       value="{{ isset($min_price)? $min_price : '' }}"
                                >
                                @error('min_price')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="number" id="max_price" name="max_price" style="width: 90px;"
                                       class="form-control p-1 m-1 @error('max_price') is-invalid @enderror"
                                       aria-label="Max price" placeholder="Max price" min="0"
                                       value="{{ isset($max_price)? $max_price : '' }}"
                                >
                                @error('max_price')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="search" id="name_search" name="name"
                                       class="form-control p-1 mr-3 ml-3 @error('name') is-invalid @enderror"
                                       aria-label="Search by name" placeholder="Search by name" autocomplete autofocus
                                       value="{{ isset($name)? $name : '' }}"
                                >
                                @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <button class="btn btn-outline-primary" type="submit">Search</button>
                        </form>
                    </div>

                </div>
                <tr class="text-primary text-uppercase">
                    <td>ID</td>
                    <td>Sku</td>
                    <td>Name</td>
                    <td style="width:300px">Description</td>
                    <td>Image</td>
                    <td>Price</td>
                    <td>Stock</td>
                    <td>Enabled</td>
                    <td>Notes</td>
                    <td colspan="2">Actions</td>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td><img src="{{ $product->image }}" style="width:80px" alt="{{ $product->name }}"></td>
                        <td>${{ $product->price }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->enabled }}</td>
                        <td>{{ $product->notes }}</td>
                        <td>
                            <a href="{{ route('admin.products.edit',$product->id)}}" class="btn btn-primary">Edit</a>
                        </td>
                        <td>
                            <form action="{{ route('admin.products.destroy', $product->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $products->render() }}
        </div>
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
