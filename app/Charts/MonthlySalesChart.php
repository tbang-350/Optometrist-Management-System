<?php

namespace App\Charts;

use App\Models\User;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\Auth;
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

        $currentLocationId = Auth::user()->location_id;

        // Fetch the data
        $salesQuery = \App\Models\PaymentDetail::query()
            ->selectRaw('SUM(current_paid_amount) as total_sales, DAY(date) as day')
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth);

        if ((int) $currentLocationId !== User::SUPER_ADMIN_LOCATION_ID) {
            $salesQuery->where('location_id', $currentLocationId);
        }

        $data = $salesQuery
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

        $chart = $this->chart->lineChart();
        $chart->setTitle("Daily Sales for $currentMonthName $currentYear");
        $chart->addLine('Total Sales', array_values($data));
        $chart->setXAxis($dates);

        return $chart;
    }
}
