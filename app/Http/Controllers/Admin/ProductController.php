<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a list of products.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $products = Product::all();
        $section_title = 'Products';

        return view('admin.products.index', compact(['products', 'section_title']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created product in storage.
     *
     * @param StoreProductRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(StoreProductRequest $request)
    {
        $price = $request->get('price') ?? 0;
        $stock = $request->get('stock') ?? 0;
        $enabled = $request->get('enabled');


        $product = new Product(
            [
                'sku' => $request->get('sku'),
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'price' => $price,
                'stock' => $stock,
                'enabled' => isset($enabled),
            ]
        );

        $product->save();

        return redirect()->route('admin.products.index')->with($type = 'success', 'Product created!');
    }

    /**
     * Display the specified product.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return null;
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param int $id
     * @return Application|RedirectResponse|Factory|View
     */
    public function edit(int $id)
    {
        if (Gate::denies('manage-products')) {
            return redirect(route('admin.products.index'))
                ->with($type = 'error', 'You do not have permission for this action');
        }

        $product = Product::find($id);

        return view('admin.products.edit', compact(['product']));
    }

    /**
     * Update the specified product in storage.
     *
     * @param UpdateProductRequest $request
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(UpdateProductRequest $request, int $id)
    {
        if (Gate::denies('manage-products')) {
            return redirect(route('admin.products.index'));
        }

        $sku = $request->get('sku');
        $name = $request->get('name');
        $price = $request->get('price') ?? 0;
        $stock = $request->get('stock') ?? 0;
        $enabled = $request->get('enabled');


        $product = Product::find($id);

        if ($product->sku != $sku) {
            $sku_validator = Validator::make(
                ['sku' => $sku], ['sku' => 'required|string|max:255|unique:products']
            );
            $sku_validator->validate();
            $product->sku = $sku;
        }
        if ($product->name != $name) {
            $name_validator = Validator::make(
                ['name' => $name], ['name' => 'required|string|max:255|unique:products']
            );
            $name_validator->validate();
            $product->name = $name;
        }
        $product->description = $request->get('description');
        $product->price = $price;
        $product->stock = $stock;
        $product->enabled = isset($enabled);

        $product->save();

        return redirect()->route('admin.products.index')->with($type = 'success', 'Product updated!');
    }

    /**
     * Remove the specified product from storage.
     *
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(int $id)
    {
        if (Gate::denies('manage-products')) {
            return redirect(route('admin.products.index'))
                ->with($type = 'error', 'You do not have permission for this action');
        }

        $product = Product::find($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted!');
    }
}