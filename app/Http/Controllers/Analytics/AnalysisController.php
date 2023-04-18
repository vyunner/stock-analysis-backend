<?php

namespace App\Http\Controllers\Analytics;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalysisController extends Controller
{
    protected Carbon $today;
    protected Carbon $firstDayOfMonth;
    protected Carbon $lastDayOfMonth;

    public function __construct()
    {
        $this->today = Carbon::now();
        $this->firstDayOfMonth = Carbon::create($this->today->year, $this->today->month, 1);
        $this->lastDayOfMonth = Carbon::create($this->today->year, $this->today->month, $this->today->daysInMonth);
    }

    public function getTopSellingAndUnsoldProducts()
    {
        $topSellingProducts = DB::table('orders')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->select('product_id', 'products.name', DB::raw('SUM(order_amount) as totalSales'),
                DB::raw('SUM(order_amount * products.price) AS totalRevenue'))
            ->whereBetween('orders.created_at', [$this->firstDayOfMonth, $this->lastDayOfMonth])
            ->groupBy('product_id')
            ->orderByDesc('totalRevenue')
            ->limit(5)
            ->get();

        $topUnsoldProducts = DB::table('orders')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->select('product_id', 'products.name', DB::raw('SUM(order_amount) as totalSales'),
                DB::raw('SUM(order_amount * products.price) AS totalRevenue'))
            ->whereBetween('orders.created_at', [$this->firstDayOfMonth, $this->lastDayOfMonth])
            ->groupBy('product_id')
            ->orderBy('totalRevenue')
            ->limit(5)
            ->get();

        return ['topSellingProducts' => $topSellingProducts, 'topUnsoldProducts' => $topUnsoldProducts];
    }
}
