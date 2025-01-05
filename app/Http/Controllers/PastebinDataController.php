<?php

namespace App\Http\Controllers;

use App\Models\PastebinData;

class PastebinDataController extends Controller
{
    public function index()
    {
        $pastebins = PastebinData::paginate(10); // Paginate with 10 items per page
        return view('pastebins.index', compact('pastebins'));
    }
}