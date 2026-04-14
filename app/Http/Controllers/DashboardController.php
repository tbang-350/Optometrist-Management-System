<?php

namespace App\Http\Controllers;

use App\Charts\MonthlySalesChart;
use App\Charts\PriceComparison;
use App\Models\Consultation;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Prescription;
use App\Models\Product;
use App\Models\Service;
use App\Models\ServicePayment;
use App\Models\ServicePaymentDetail;
use App\Models\User;
use App\Models\Location;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke(MonthlySalesChart $monthlySalesChart, PriceComparison $priceComparison)
    {
        $user = Auth::user();
        $isSuperAdmin = (int) $user->location_id === User::SUPER_ADMIN_LOCATION_ID;
        $currentLocationId = $user->location_id;

        $today = Carbon::now()->toDateString();
        $last30DaysStart = Carbon::now()->subDays(29)->toDateString();

        $totalProductSales = (float) PaymentDetail::sum('current_paid_amount');
        $totalServiceSales = (float) ServicePaymentDetail::sum('current_paid_amount');

        $todayProductSales = (float) PaymentDetail::whereDate('date', $today)->sum('current_paid_amount');
        $todayServiceSales = (float) ServicePaymentDetail::whereDate('date', $today)->sum('current_paid_amount');

        $totalCustomers = Customer::count();
        $newCustomersToday = Customer::whereDate('created_at', $today)->count();

        $totalServices = Service::count();

        $employeeQuery = User::query()->whereIn('role', [2, 3]);
        if (! $isSuperAdmin) {
            $employeeQuery->where('location_id', $currentLocationId);
        }
        $totalEmployees = $employeeQuery->count();

        $totalLocations = Location::count();
        $totalStock = Product::count();

        $pendingInvoices = Invoice::where('status', '0')->count();
        $approvedInvoices = Invoice::where('status', '1')->count();

        $productDueTotal = (float) Payment::whereIn('paid_status', ['full_due', 'partial_paid'])->sum('due_amount');
        $serviceDueTotal = (float) ServicePayment::whereIn('paid_status', ['full_due', 'partial_paid'])->sum('due_amount');

        $unseenConsultations = Consultation::where('status', '0')->count();
        $consultationsToday = Consultation::whereDate('date', $today)->count();

        $prescriptionsToday = Prescription::whereDate('date', $today)->count();

        $lowStockQuery = Product::query()->whereColumn('quantity', '<=', 'reorder_level');
        $lowStockCount = $lowStockQuery->count();
        $lowStockProducts = $lowStockQuery
            ->select(['id', 'name', 'quantity', 'reorder_level'])
            ->orderBy('quantity', 'asc')
            ->limit(5)
            ->get();

        $topProducts = DB::table('invoice_details')
            ->join('invoices', 'invoice_details.invoice_id', '=', 'invoices.id')
            ->join('products', 'invoice_details.product_id', '=', 'products.id')
            ->select([
                'invoice_details.product_id',
                'products.name as product_name',
                DB::raw('SUM(invoice_details.selling_qty) as total_qty'),
            ])
            ->where('invoice_details.status', 1)
            ->where('invoices.status', '1')
            ->whereBetween('invoice_details.date', [$last30DaysStart, $today])
            ->when(! $isSuperAdmin, function ($query) use ($currentLocationId) {
                $query->where('invoices.location_id', $currentLocationId);
            })
            ->groupBy('invoice_details.product_id', 'products.name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        $latestInvoices = Invoice::with(['payment.customer'])
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        $stats = [
            'totalProductSales' => $totalProductSales,
            'totalServiceSales' => $totalServiceSales,
            'todayProductSales' => $todayProductSales,
            'todayServiceSales' => $todayServiceSales,
            'totalCustomers' => $totalCustomers,
            'newCustomersToday' => $newCustomersToday,
            'totalServices' => $totalServices,
            'totalEmployees' => $totalEmployees,
            'totalLocations' => $totalLocations,
            'totalStock' => $totalStock,
            'pendingInvoices' => $pendingInvoices,
            'approvedInvoices' => $approvedInvoices,
            'productDueTotal' => $productDueTotal,
            'serviceDueTotal' => $serviceDueTotal,
            'unseenConsultations' => $unseenConsultations,
            'consultationsToday' => $consultationsToday,
            'prescriptionsToday' => $prescriptionsToday,
            'lowStockCount' => $lowStockCount,
        ];

        return view('admin.index', [
            'stats' => $stats,
            'lowStockProducts' => $lowStockProducts,
            'topProducts' => $topProducts,
            'latestInvoices' => $latestInvoices,
            'chart' => $monthlySalesChart->build(),
            'chart2' => $priceComparison->build(),
        ]);
    }
}
