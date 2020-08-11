@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="display-3">Products</h1>
                    <table class="table table-striped table-sm">
                        <thead>
                        <div class="navbar">
                            <div class="form-inline float-right">
                                <form id="admin_product_search" action="{{ route('shop.products.index')}}" class="form-inline">
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
                            <td>Name</td>
                            <td>Description</td>
                            <td>Image</td>
                            <td>Price</td>
                            <td>Stock</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->description }}</td>
                                <td><img src="{{ $product->image }}" style="width:80px" alt="{{ $product->name }}"></td>
                                <td>${{ $product->price }}</td>
                                <td>{{ $product->stock == 0 ? 'Sold out' : $product->stock }}</td>
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
        </div>
    </div>
@endsection
