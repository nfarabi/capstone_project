<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Copy;
use App\Http\Controllers\Controller;
use App\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [
            'pages' => Page::paginate( config('cms.pagination') )
        ];

        return view('admin.pages.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate( self::_getValidation($request) );

        $page = new Page( $request->input() );
        $page->feature($request->input('is_featured'));
        $page->homepage($request->input('is_homepage'));
        $page->setPrivate($request->input('is_private'));
        $page->publish($request->input('published_at'));

        // Upload image
        if (! empty($request->file('image'))) {
            $image_upload_status = self::_fileUpload( $page, $request );
        }

        $page->save();

        if ( isset( $image_upload_status ) && ! $image_upload_status  ) {
            flash()->success( __('models.pages.created-but-image-upload-failed') );
        } else {
            flash()->success( __('models.pages.created') );
        }

        return redirect()->route('admin.pages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Page $page)
    {
        $data = [
            'page' => $page,
        ];

        return view( 'admin.pages.edit', $data );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $request->validate( self::_getValidation($request) );

        $page->fill( $request->input() );
        $page->feature($request->input('is_featured'));
        $page->homepage($request->input('is_homepage'));
        $page->setPrivate($request->input('is_private'));
        $page->publish($request->input('published_at'));

        // Upload image
        if (! empty($request->file('image'))) {
            $image_upload_status = self::_fileUpload( $page, $request );
        }

        $page->save();

        if ( isset( $image_upload_status ) && ! $image_upload_status  ) {
            flash()->success( __('models.pages.updated-but-image-upload-failed') );
        } else {
            flash()->success( __('models.pages.updated') );
        }

        return redirect()->route('admin.pages.edit', $page);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        try {
            $page->delete();
            flash()->success( __('models.pages.deleted') );
        } catch (\Exception $exception) {
            flash()->error( __('models.pages.delete-failed') );
        }

        return redirect()->route('admin.pages.index');
    }

    /**
     * Toggle the specified resource in storage as published/unpublished.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Page  $page
     * @return void
     */
    public function publish(Request $request, Page $page)
    {
        $page->publish(! $page->published_at);
        $page->save();
    }

    /**
     * Copy from an existing resource for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function copy()
    {
        $data = [
            'pages' => Page::all(),
        ];

        return view( 'admin.pages.copy', $data );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function copyProcess( Request $request )
    {
        $request->validate( self::_getValidation($request) );

        $page = Page::find( $request->input('page_id') );

        Copy::page( $page );

        flash()->success( __('models.pages.copied') );

        return redirect()->route('admin.pages.index');
    }

    /**
     * Upload file.
     *
     * @param  \App\Page  $page
     * @param  \Illuminate\Http\Request  $request
     * @return boolean $upload
     */
    protected static function _fileUpload( Page $page, Request $request )
    {
        $upload = true;

        try {
            $page->image = $request->file('image')->store('public/pages');
            $page->image_name = $request->file('image')->getClientOriginalName();
        } catch (\Exception $exception) {
            $upload = false;
        }

        return $upload;
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
                    'title'     => 'required|string|max:191',
                    'slug'      => 'nullable|string|max:191',
                    'excerpt'   => 'nullable|string',
                    'image'     => 'nullable|image|mimes:jpeg,jpg,png,bmp,gif,svg,webp|max:2048',
                ];
                break;
            case 'copyProcess':
                $rules = [
                    'page_id'   => 'required|exists:pages,id',
                ];
                break;
        }

        return $rules;
    }
}
