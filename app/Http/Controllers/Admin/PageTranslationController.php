<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\LanguageLine;
use App\Page;
use Illuminate\Http\Request;

class PageTranslationController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Page $page
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit( Request $request, Page $page)
    {
        $data = [
            'page'              => $page,
            'language_lines'    => LanguageLine::where('group', $page->slug)->get(),
        ];

        return view('admin.pages.translations.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Page  $page
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Page $page)
    {
        $language_lines = LanguageLine::where('group', $page->slug)->get();

        $translations = $request->get('language_line', []);

        foreach ($translations as $key => $translation) {
            $language_line = $language_lines->firstWhere('key', $key);
            $language_line->setTranslation($translation);
            $language_line->save();
        }

        flash()->success( __('models.pages.translation-updated') );

        return redirect()->back();
    }
}
