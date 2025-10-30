<?php

namespace App\Http\Controllers\manufacturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManufacturerDashboardController extends Controller
{
    public function index()
    {
        return view('manufacturer.dashboard.index');
    }
}
