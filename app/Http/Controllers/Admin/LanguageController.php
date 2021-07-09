<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Copy;
use App\Http\Controllers\Controller;
use App\Language;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.languages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('admin.languages.create');
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

        $language = new Language( $request->input() );
        $language->activate($request->input('activated_at'));

        $language->save();

        flash()->success( __('models.languages.created') );

        return redirect()->route('admin.languages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function show(Language $language)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Language  $language
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Language $language)
    {
        $data = [
            'language' => $language,
        ];

        return view('admin.languages.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Language  $language
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Language $language)
    {
        $request->validate( self::_getValidation($request, $language) );

        $language->fill( $request->input() );
        $language->activate($request->input('activated_at'));

        $language->save();

        flash()->success( __('models.languages.updated') );

        return redirect()->route('admin.languages.edit', $language);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Language  $language
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Language $language)
    {
        try {
            $language->delete();
            flash()->success( __('models.languages.deleted') );
        } catch (\Exception $exception) {
            flash()->error( __('models.languages.delete-failed') );
        }

        return redirect()->route('admin.languages.index');
    }

    /**
     * Toggle the specified resource in storage as activated/deactivated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Language  $language
     * @return void
     */
    public function activate(Request $request, Language $language)
    {
        $language->activate(! $language->activated_at);
        $language->save();
    }

    /**
     * Copy from an existing resource for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function copy()
    {
        return view('admin.languages.copy');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function copyProcess( Request $request )
    {
        $request->validate( self::_getValidation($request) );

        $language = Language::find( $request->input('language_id') );

        Copy::language( $language );

        flash()->success( __('models.languages.copied') );

        return redirect()->route('admin.languages.index');
    }

    /**
     * Switch active language for current user.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchLanguage( Request $request )
    {
        if ( !$request->filled('language_code') ) {
            flash()->error( __('models.languages.invalid-value') );
        } else {
            $language = Language::where( 'code', $request->query('language_code') )->first();

            if ( !$language ) {
                flash()->error( __('models.languages.invalid-value') );
            } else {
                flash()->success( "You are now editing content for {$language->label} version of the site." );

                Cookie::queue( 'languageCode', $language->code );
            }
        }

        return redirect()->back();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param Request $request
     * @param null $language
     * @return array $rules
     */
    protected static function _getValidation( Request $request, $language = null )
    {
        $rules = [];

        switch ( $request->route()->getActionMethod() ) {
            case 'store':
                $rules = [
                    'label'     => 'required|string|max:191',
                    'code'      => 'required|string|max:10|unique:languages,code',
                ];
                break;
            case 'update':
                $rules = [
                    'label'     => 'required|string|max:191',
                    'code'      => [
                        'required',
                        'string',
                        'max:10',
                        Rule::unique('languages', 'code')->ignore($language),
                    ],
                ];
                break;
            case 'copyProcess':
                $rules = [
                    'language_id'   => 'required|exists:languages,id',
                ];
                break;
        }

        return $rules;
    }
}
