<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    protected function credentials(Request $request)
    {
        return $request->only('id', 'password', 'password_confirmation', 'token');
    }
}
