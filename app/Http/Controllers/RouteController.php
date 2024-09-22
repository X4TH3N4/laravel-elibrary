<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteController extends Controller
{

    public function about()
    {
        return view('pages.about');
    }

    public function announcements()
    {
        return view('pages.announcements');
    }

    public function gallery()
    {
        return view('pages.gallery');
    }

    public function contact()
    {
        return view('pages.contact');
    }
}
