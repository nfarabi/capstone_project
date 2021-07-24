<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Product;
use App\ProductCategory;
use App\ProductInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use League\Csv\Reader;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [
            'products' => Product::with([
                    'category',
                    'merchant' => function ($query) {
                        $query->select('id', 'name', 'slug');
                    }
                ])->active()->paginate( config('cms.pagination') )
        ];

        return view('shop.index', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Product $product)
    {
        $data = [
            'product' => $product
        ];

        return view('shop.product', $data);
    }
}
