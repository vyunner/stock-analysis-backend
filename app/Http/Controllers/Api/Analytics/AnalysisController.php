<?php

namespace App\Http\Controllers\Api\Analytics;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalysisController extends Controller
{
    protected Carbon $today;
    protected Carbon $firstDayOfMonth;
    protected Carbon $lastDayOfMonth;
    protected Carbon $twoWeeks;

    public function __construct()
    {
        $this->today = Carbon::now();
        $this->firstDayOfMonth = Carbon::create($this->today->year, $this->today->month, 1);
        $this->lastDayOfMonth = Carbon::create($this->today->year, $this->today->month, $this->today->daysInMonth);
        $this->twoWeeks = $this->today->clone()->addWeeks(2);
    }

    public function getTopSoldAndUnsoldProducts()
    {
        $topSoldProducts = DB::table('orders')
            ->select('product_id', 'products.name', DB::raw('SUM(order_amount) as totalSales'),
                DB::raw('SUM(order_amount * products.price) AS totalRevenue'))
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->whereBetween('orders.created_at', [$this->firstDayOfMonth, $this->lastDayOfMonth])
            ->groupBy('product_id')
            ->orderByDesc('totalRevenue')
            ->limit(5)
            ->get();

        $topUnsoldProducts = DB::table('orders')
            ->select('product_id', 'products.name', DB::raw('SUM(order_amount) as totalSales'),
                DB::raw('SUM(order_amount * products.price) AS totalRevenue'))
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->whereBetween('orders.created_at', [$this->firstDayOfMonth, $this->lastDayOfMonth])
            ->groupBy('product_id')
            ->orderBy('totalRevenue')
            ->limit(5)
            ->get();

        return ['topSellingProducts' => $topSoldProducts, 'topUnsoldProducts' => $topUnsoldProducts];
    }

    public function getExpiredProducts()
    {
        $expired = DB::table('products')
            ->select('id AS product_id', 'name', 'product_amount', 'expiry_date')
            ->where('expiry_date', '<', $this->today)
            ->get();

        $expiringSoon = DB::table('products')
            ->select('id AS product_id', 'name', 'product_amount', 'expiry_date')
            ->whereBetween('expiry_date', [$this->today, $this->twoWeeks])
            ->get();

        return [
            'expired' => $expired->isEmpty() ? false : $expired,
            'expiring_soon' => $expiringSoon->isEmpty() ? false : $expiringSoon
        ];
    }
}
