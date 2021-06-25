<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Artisan;
use Illuminate\Http\Request;

class MiscController extends Controller
{
    /**
     * Clear website cache that was generated over time
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearCache()
    {
        Artisan::call('cache:clear');

        flash()->success('Website cache cleared.');

        return back();
    }
}
