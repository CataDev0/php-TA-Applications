<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function error() {
        $error = request('message', 'An error occurred');
        return view('error', ['error' => $error]);
    }
}
