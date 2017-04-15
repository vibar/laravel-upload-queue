<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProduct;
use App\Http\Requests\UpdateProduct;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreProduct $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduct $request)
    {
        $filename = md5(microtime()).'.xslx';

        try {
            $request->file('file')->storeAs('spreadsheets', $filename);
            // job dispatch
            $request->session()->flash('success', 'The file is being imported, please wait...');
        } catch (\Exception $e) {
            $request->session()->flash('error', $e->getMessage());
        }

        return view('product.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateProduct $request
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProduct $request, Product $product)
    {
        $product->fill($request->all());
        $product->save();

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('product.index');
    }
}
