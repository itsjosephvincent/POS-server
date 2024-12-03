<?php

namespace App\Repositories;

use App\Interfaces\Repositories\OrdersReportRepositoryInterface;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrdersReportRepository implements OrdersReportRepositoryInterface
{
    public function findMany(object $payload, string $sortField, string $sortOrder)
    {
        $user = Auth::user();
        $admin_id = $user->id;
        if ($user->getRoleNames()[0] === 'store') {
            $admin_id = $user->admin_id;
        }
        if ($payload->date) {
            $date = explode(',', $payload->date);
            $start_date = $date[0];
            $end_date = $date[1];
        }

        $orders = Order::select('orders.*', 'stores.uuid as store_uuid', 'stores.store_name as store_name', 'stores.branch as branch', 'cashiers.name as cashier_name')
            ->join('cashiers', 'orders.cashier_id', '=', 'cashiers.id')
            ->join('stores', 'cashiers.store_id', '=', 'stores.id')
            ->whereIn('cashier_id', function ($query) use ($admin_id) {
                $query->select('cashiers.id')
                    ->from('admins')
                    ->join('stores', 'admins.id', '=', 'stores.admin_id')
                    ->join('cashiers', 'cashiers.store_id', '=', 'stores.id')
                    ->where('admins.id', $admin_id);
            });

        if ($payload->date) {
            $orders ->whereBetween(DB::raw('UNIX_TIMESTAMP(orders.created_at)'), [$start_date, $end_date]);
        }
        $orders = $orders->filter($payload->all())
        ->orderBy($sortField, $sortOrder)
        ->paginate(config('paginate.page'));

        return $orders;
    }
}
