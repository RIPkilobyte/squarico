<?php

namespace App\Http\Controllers;

class OpportunitiesController extends Controller
{
    public function index()
    {
        return view('opportunities.index', [
            'title' => 'Opportunities',
        ]);
    }
}
