<?php

namespace App\Http\Controllers;

use App\Helper\JWToken;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(Request $request) {
        $token = request()->cookie('token');
        $user = JWToken::verifyToken($token);

        return view('pages.dashboard.dashboard-page')->with('user', $user->email)->with('id', $user->id);
    }
}
