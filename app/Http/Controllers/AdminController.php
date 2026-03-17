<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminController extends Controller
{
    public function listBusinessRegistrations() {
        $businessUsers = User::where('role', 'business advertiser');

        return view('admin.listBusinessRegistrations', ['businessUsers' => $businessUsers]);
    }
}
