<?php

namespace App\Http\Controllers;

use App\Models\PastebinError;

class PastebinErrorController extends Controller
{
    public function index()
    {
        $errors = PastebinError::paginate(10); // Paginate with 10 items per page
        return view('pastebin_errors.index', compact('errors'));
    }
}