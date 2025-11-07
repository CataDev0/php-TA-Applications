<?php

namespace App\Http\Controllers;

// Default controller
abstract class Controller
{
    // Default error view
    public function error() {
        $error = request('message', 'An error occurred');
        return view('error', ['error' => $error]);
    }
}
