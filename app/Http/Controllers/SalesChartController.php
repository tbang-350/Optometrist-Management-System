<?php

namespace App\Http\Controllers;

use App\Charts\DailySalesChart;
use Illuminate\Http\Request;

class SalesChartController extends Controller
{
    public function index(DailySalesChart $dailySalesChart)
    {
        $chart = $dailySalesChart->build();

        return view('backend.invoice.invoice_chart', compact('chart'));
    }
}
