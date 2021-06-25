<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Page;
use App\PageBlock;
use Illuminate\Http\Request;

class PageBlockController extends Controller
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
            'page'      => $page,
            'blocks'    => $page->getBlockArray( $request->get('_language') ),
        ];

        return view('admin.pages.blocks.edit', $data);

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
        $page->saveBlocks( $request->get('_language'), $request->get('blocks', []) );

        flash()->success( __('models.pages.block-updated') );

        return redirect()->back();
    }
}
