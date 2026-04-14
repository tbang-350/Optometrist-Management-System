<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\PaymentDetail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PriceComparison
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $monthStart = Carbon::now()->startOfMonth()->toDateString();
        $monthEnd = Carbon::now()->endOfMonth()->toDateString();

        $rows = PaymentDetail::query()
            ->select('payment_option', DB::raw('SUM(current_paid_amount) as total_amount'))
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->whereNotNull('payment_option')
            ->groupBy('payment_option')
            ->orderByDesc('total_amount')
            ->limit(6)
            ->get();

        $labels = $rows->pluck('payment_option')->map(function ($value) {
            return (string) $value;
        })->toArray();

        $values = $rows->pluck('total_amount')->map(function ($value) {
            return (float) $value;
        })->toArray();

        if (count($values) === 0) {
            $labels = ['No data'];
            $values = [0];
        }

        $chart = $this->chart->pieChart();
        $chart->setTitle('Payment Options (This Month)');
        $chart->setSubtitle("$monthStart to $monthEnd");
        $chart->addPieces($values);
        $chart->setLabels($labels);

        return $chart;
    }
}
