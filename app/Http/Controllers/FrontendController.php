<?php

namespace App\Http\Controllers;

use App\Models\Contactinfo;
use App\Models\Contactqueries;
use App\Models\Pages;
use App\Models\Service;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        return view('frontend.pages.home');
    }

    public function quizes() {
        return view('frontend.pages.main');
    }
}
