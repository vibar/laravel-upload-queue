<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProduct;
use App\Http\Requests\UpdateProduct;
use App\Jobs\ProcessProducts;
use App\Product;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->productRepository->all('lm');

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
        $filename = md5(microtime()).'.xlsx';

        try {
            $request->file('file')->storeAs('spreadsheets', $filename);
            dispatch(new ProcessProducts($filename));
            $request->session()->flash('success', 'Processing, please wait...');
        } catch (\Exception $e) {
            $request->session()->flash('error', 'An error has occurred.');
            Log::error($e->getMessage());
        }

        return view('product.create');
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
        $data = $request->except('lm');
        $this->productRepository->update($product->id, $data);

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
        $this->productRepository->delete($product->id);

        return redirect()->route('product.index');
    }
}
