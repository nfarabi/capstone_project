<?php

namespace App\Http\Controllers\Admin;

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
            'products' => Product::where('merchant_id', auth()->id())->paginate( config('cms.pagination') )
        ];

        return view('admin.products.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $data = [
            'productCategories' => ProductCategory::active()->get()
        ];

        return view('admin.products.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate( self::_getValidation($request) );

        $product = new Product( $request->input() );

        $product->category()->associate($request->input('category_id'));
        $product->merchant()->associate(auth()->id());
        $product->activate($request->input('activated_at'));

        $product->save();

        flash()->success( __('models.products.created') );

        return redirect()->route('admin.products.index');
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Product $product)
    {
        $data = [
            'product' => $product,
            'productCategories' => ProductCategory::active()->get()
        ];

        return view( 'admin.products.edit', $data );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Product $product)
    {
        $request->validate( self::_getValidation($request) );

        $product->fill( $request->input() );
        $product->category()->associate($request->input('category_id'));
        $product->activate($request->input('activated_at'));

        $product->save();

        flash()->success( __('models.products.updated') );

        return redirect()->route('admin.products.edit', $product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            flash()->success( __('models.products.deleted') );
        } catch (\Exception $exception) {
            flash()->error( __('models.products.delete-failed') );
        }

        return redirect()->route('admin.products.index');
    }

    /**
     * Toggle the specified resource in storage as activated/deactivated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return void
     */
    public function activate(Request $request, Product $product)
    {
        $product->activate(! $product->activated_at);
        $product->save();
    }

    public function import(Request $request)
    {
        if ($request->query('template')) {
            return response()->csv('name,short_description,long_description,sku,uuid,price,inventory,discount,category_id', 'product-import-template', false);
        }

        return view( 'admin.products.import' );
    }

    public function importProcess(Request $request)
    {
        $request->validate( self::_getValidation($request) );

        $products = Product::where('merchant_id', auth()->id())->get();

        $reader = Reader::createFromPath($request->file('csv'), 'r');
        $reader->setHeaderOffset(0);
        $records = $reader->getRecords();

        foreach ($records as $record) {
            $values = [
                'name' => $record['name'],
                'short_description' => Str::limit($record['short_description'], 255, ''),
                'long_description' => $record['long_description'],
                'sku' => $record['sku'],
                'uuid' => $record['uuid'],
                'price' => !empty($record['price']) ? $record['price'] : 0,
                'inventory' => !empty($record['inventory']) ? $record['inventory'] : null,
                'discount' => !empty($record['discount']) ? $record['discount'] : null,
            ];

            if (!empty($record['uuid']) && !empty($product = $products->firstWhere('uuid', $record['uuid']))) {
                $product->fill( $values );
            } else {
                $product = new Product( $values );
                $product->merchant()->associate(auth()->id());
            }

            $product->save();
        }

        return redirect()->route('admin.products.index');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array $rules
     */
    protected static function _getValidation( Request $request )
    {
        $rules = [];

        switch ( $request->route()->getActionMethod() ) {
            case 'store':
            case 'update':
                $rules = [
                    'name'              => 'required|string|max:191',
                    'short_description' => 'nullable|string',
                    'long_description'  => 'nullable|string',
                    'sku'               => 'nullable|string',
                    'price'             => 'required|integer',
                    'inventory'         => 'nullable|integer',
                    'discount'          => 'nullable|numeric',
                ];
                break;
            case 'importProcess':
                $rules = [
                    'csv'               => 'required|file|mimes:csv,txt'
                ];
        }

        return $rules;
    }
}
