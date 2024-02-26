<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class MonthlySalesChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        // Get the current year and month
        $currentYear = date('Y');
        $currentMonth = date('m');

        // Get the name of the current month
        $currentMonthName = date('F');

        // Calculate the number of days in the current month
        $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

        // Generate an array of dates for the current month
        $dates = [];
        for ($day = 1; $day <= $numberOfDays; $day++) {
            $dates[] = $day;
        }

        // Fetch the data
        $data = \App\Models\PaymentDetail::query()
            ->selectRaw('SUM(current_paid_amount) as total_sales, DAY(date) as day')
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->groupBy(DB::raw('DAY(date)'))
            ->pluck('total_sales', 'day')
            ->toArray();

        // Fill in missing days with 0 sales
        for ($day = 1; $day <= $numberOfDays; $day++) {
            if (!isset($data[$day])) {
                $data[$day] = 0;
            }
        }

        // Sort the data by day
        ksort($data);

        return $this->chart->lineChart()
            ->setTitle("Daily Sales for $currentMonthName $currentYear")
            ->addLine('Total Sales', array_values($data))
            ->setXAxis($dates);
    }
}
