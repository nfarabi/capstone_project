<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [
            'productCategories' => ProductCategory::paginate( config('cms.pagination') )
        ];

        return view('admin.product-categories.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $data = [
            'productCategories' => ProductCategory::all()
        ];

        return view('admin.product-categories.create', $data);
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

        $productCategory = new ProductCategory( $request->input() );
        $productCategory->activate($request->input('activated_at'));

        $parent_id = $request->filled('parent_id') ? $request->input('parent_id') : null;
        $productCategory->parent()->associate( $parent_id );

        $productCategory->save();


        flash()->success( __('models.product-categories.created') );

        return redirect()->route('admin.product-categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(ProductCategory $productCategory)
    {
        $data = [
            'productCategory' => $productCategory,
            'productCategories' => ProductCategory::all()
        ];

        return view( 'admin.product-categories.edit', $data );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $request->validate( self::_getValidation($request) );

        $productCategory->fill( $request->input() );
        $productCategory->activate($request->input('activated_at'));

        $parent_id = $request->filled('parent_id') ? $request->input('parent_id') : null;
        $productCategory->parent()->associate( $parent_id );

        $productCategory->save();

        flash()->success( __('models.product-categories.updated') );

        return redirect()->route('admin.product-categories.edit', $productCategory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ProductCategory $productCategory)
    {
        try {
            $productCategory->delete();
            flash()->success( __('models.product-categories.deleted') );
        } catch (\Exception $exception) {
            flash()->error( __('models.product-categories.delete-failed') );
        }

        return redirect()->route('admin.product-categories.index');
    }

    /**
     * Toggle the specified resource in storage as activated/deactivated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductCategory  $productCategory
     * @return void
     */
    public function activate(Request $request, ProductCategory $productCategory)
    {
        $productCategory->activate(! $productCategory->activated_at);
        $productCategory->save();
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
                    'name'          => 'required|string|max:191',
                    'slug'          => 'nullable|string|max:191',
                    'description'   => 'nullable|string',
                ];
                break;
        }

        return $rules;
    }
}
