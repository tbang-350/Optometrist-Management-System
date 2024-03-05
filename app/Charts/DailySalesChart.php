<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class DailySalesChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        // $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        // return $this->chart->barChart()
        //     ->setTitle('Monthly Sales')
        //     ->addData('Monthly Sales', \App\Models\PaymentDetail::query()->selectRaw('SUM(current_paid_amount) as total_sales')->groupBy(DB::raw('YEAR(date)'), DB::raw('MONTH(date)'))->pluck('total_sales')->toArray())
        //     ->setXAxis($months);

        // Get the current year
        $currentYear = date('Y');

        // Generate an array of dates for the current year
        $dates = [];
        $startOfYear = strtotime("{$currentYear}-01-01");
        $endOfYear = strtotime("{$currentYear}-12-31");
        $currentDate = $startOfYear;
        while ($currentDate <= $endOfYear) {
            $dates[] = date('Y-m-d', $currentDate);
            $currentDate = strtotime('+1 day', $currentDate);
        }

        return $this->chart->barChart()
            ->setTitle('Monthly Sales')
            ->addData('Daily Sales', \App\Models\PaymentDetail::query()->selectRaw('SUM(current_paid_amount) as total_sales')->whereYear('date', $currentYear)->groupBy(DB::raw('MONTH(date)'))->pluck('total_sales')->toArray())
            ->setXAxis($dates)
            ->setColors(['#ffc63b', '#ff6384']);

    }
}
