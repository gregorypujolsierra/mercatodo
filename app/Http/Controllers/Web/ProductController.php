<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\SearchProductRequest;
use App\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     *
     * @param SearchProductRequest $request
     * @return Application|Factory|View
     */
    public function index(SearchProductRequest $request)
    {
        /**
         * @todo Make Javascript "Order by" price
         */
        $name = $request->get('name');
        $price_range = $this->pricesearchrange($request->get('min_price'), $request->get('max_price'));
        $min_price = $price_range[0];
        $max_price = $price_range[1];

        $products = Product::where('enabled', 1)
            ->namelike($name)
            ->pricegreaterthan($min_price)
            ->pricelessthan($max_price)
            ->orderBy('id', 'DESC')
            ->paginate(config('app.default_pagination', 5));

        return view('web.products.index', compact(['products', 'name', 'min_price', 'max_price']));
    }

    /**
     * Display the specified product.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
}
