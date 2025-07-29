<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function handleRedirect($slug)
    {
        $link = Link::where('slug', $slug)->firstOrFail();
        $link->increment('clicks');
        return view('link-redirect', compact('link'));
    }
}
