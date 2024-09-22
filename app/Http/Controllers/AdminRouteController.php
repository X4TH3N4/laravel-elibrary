<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminRouteController extends Controller
{
    public function auditLog() {
        return view('admin.pages.auditLog');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function data()
    {
        return view('admin.pages.data');
    }

    public function members()
    {
        return view('admin.pages.members');
    }

    public function announcementDashboard()
    {
        return view('admin.pages.announcements');
    }
}
