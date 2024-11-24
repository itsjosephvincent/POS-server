<?php

namespace App\Repositories;

use App\Interfaces\Repositories\OrdersReportRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrdersReportRepository implements OrdersReportRepositoryInterface
{
    public function findMany(object $payload, string $sortField, string $sortOrder)
    {
        $user = Auth::user();
        $admin_id = $user->id;
        if ($user->getRoleNames()[0] === 'store') {
            $admin_id = $user->admin_id;
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
        })
        ->filter($payload->all())
        ->orderBy($sortField, $sortOrder)
        ->paginate(config('paginate.page'));

        return $orders;
    }
}