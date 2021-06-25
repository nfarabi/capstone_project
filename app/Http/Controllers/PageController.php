<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Contracts\Support\Renderable|\Illuminate\Http\RedirectResponse
     */
    public function show( Request $request, Page $page )
    {
        return view('welcome');
    }
}
