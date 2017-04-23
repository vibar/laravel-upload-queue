<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Jobs\ProcessProducts;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * @var \App\Repositories\ProductRepository
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
     * @param StoreProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $product = $this->productRepository->find($id);

        return view('product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProductRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, int $id)
    {
        $data = $request->except('lm');
        $this->productRepository->update($id, $data);

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $this->productRepository->delete($id);

        return redirect()->route('product.index');
    }
}
