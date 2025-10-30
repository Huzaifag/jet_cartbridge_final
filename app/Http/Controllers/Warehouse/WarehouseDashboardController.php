<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WarehouseDashboardController extends Controller
{
    public function index(){
        return view('warehouse.dashboard.index');
    }
}
