<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function summary(Request $request)
    {
        try {
            $bindings = [];
            $query = 'SELECT COALESCE(SUM(C.price), 0.00) as total_payments, COALESCE(SUM(C.cost), 0.00) as total_cost, COALESCE(SUM(C.price) - SUM(C.cost), 0.00) as total_earnings
            FROM orders as A
            LEFT JOIN order_details as B ON A.id=B.order_id LEFT JOIN products as C ON B.product_id=C.id LEFT JOIN cashiers as D ON A.cashier_id=D.id LEFT JOIN stores as E ON D.store_id=E.id
            
            ';

            if ($request->date || $request->store) {
                $query .= ' WHERE ';
            }

            if ($request->date) {
                $date = $request->date;
                $start_date = "$date 00:00:00";
                $end_date = "$date 23:59:59";
                $bindings['start_date'] = $start_date;
                $bindings['end_date'] = $end_date;

                $query .= ' A.created_at between :start_date and :end_date';
            }

            if ($request->store) {
                $store = $request->store;
                $bindings['store_uuid'] = $store;
                if ($request->date) {
                    $query .= ' AND ';
                }
                $query .= ' E.uuid = :store_uuid ';
            }

            $results = DB::select($query, $bindings);

            return response()->json([
                'data' => ! empty($results) ? $results[0] : null,
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'is_error' => true,
                'message' => "Error fetching report summary for $date",
                'error' => $exception->getMessage(),
            ], status: 400);
        }
    }

    public function popular_items(Request $request)
    {
        try {
            $bindings = [];
            $query = 'SELECT E.uuid, C.id as product_id, C.name as product_name, B.price, C.cost, SUM(B.quantity)as quantity, SUM(B.price * B.quantity) as sold, SUM(B.price * B.quantity) - SUM(C.cost * B.quantity) as earnings
            FROM orders as A
            LEFT JOIN order_details as B ON A.id=B.order_id LEFT JOIN products as C ON B.product_id=C.id LEFT JOIN cashiers as D ON A.cashier_id=D.id LEFT JOIN stores as E ON D.store_id=E.id
            ';

            if ($request->date || $request->store) {
                $query .= ' WHERE ';
            }

            if ($request->date) {
                $date = $request->date;
                $start_date = "$date 00:00:00";
                $end_date = "$date 23:59:59";
                $bindings['start_date'] = $start_date;
                $bindings['end_date'] = $end_date;

                $query .= ' A.created_at between :start_date and :end_date ';
            }
            if ($request->store) {
                $store = $request->store;
                $bindings['store_uuid'] = $store;
                if ($request->date) {
                    $query .= ' AND ';
                }
                $query .= ' E.uuid = :store_uuid ';
            }
            $query .= ' GROUP BY E.uuid, C.id, C.name, C.cost, B.price ORDER BY quantity DESC LIMIT 5;';

            $results = DB::select($query, $bindings);

            return response()->json([
                'data' => $results,
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'is_error' => true,
                'message' => 'Error fetching report summary for',
                'error' => $exception->getMessage(),
            ], status: 400);
        }
    }

    public function category_earnings(Request $request)
    {
        try {
            $bindings = [];
            $query = 'SELECT C.category_id, D.name, SUM(B.quantity) as total_quantity, SUM(C.cost * B.quantity) as total_cost, SUM(B.price * B.quantity) as sold, SUM(B.price * B.quantity) - SUM(C.cost * B.quantity) as earnings
            FROM orders as A
            LEFT JOIN order_details as B ON A.id=B.order_id LEFT JOIN products as C ON B.product_id=C.id
            LEFT JOIN categories as D ON D.id=C.category_id LEFT JOIN cashiers as E ON A.cashier_id=E.id LEFT JOIN stores as F ON E.store_id=F.id
            ';

            if ($request->date || $request->store) {
                $query .= ' WHERE ';
            }
            if ($request->date) {
                $date = $request->date;
                $start_date = "$date 00:00:00";
                $end_date = "$date 23:59:59";
                $bindings['start_date'] = $start_date;
                $bindings['end_date'] = $end_date;

                $query .= ' A.created_at between :start_date and :end_date ';
            }
            if ($request->store) {
                $store = $request->store;
                $bindings['store_uuid'] = $store;
                if ($request->date) {
                    $query .= ' AND ';
                }
                $query .= ' F.uuid = :store_uuid ';
            }
            $query .= ' GROUP BY C.category_id, D.name';

            $results = DB::select($query, $bindings);

            return response()->json([
                'data' => $results,
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'is_error' => true,
                'message' => 'Error fetching report summary for',
                'error' => $exception->getMessage(),
            ], status: 400);
        }
    }

    public function store_earnings(Request $request)
    {
        try {
            $bindings = [];
            $query = 'SELECT E.uuid, E.store_name, E.branch, SUM(B.quantity)as quantity, SUM(B.price * B.quantity) as sold, SUM(B.price * B.quantity) - SUM(C.cost * B.quantity) as earnings
            FROM orders as A
            LEFT JOIN order_details as B ON A.id=B.order_id LEFT JOIN products as C ON B.product_id=C.id LEFT JOIN cashiers as D ON A.cashier_id=D.id LEFT JOIN stores as E ON D.store_id=E.id
            ';

            if ($request->date) {
                $query .= ' WHERE ';
            }
            if ($request->date) {
                $date = $request->date;
                $start_date = "$date 00:00:00";
                $end_date = "$date 23:59:59";
                $bindings['start_date'] = $start_date;
                $bindings['end_date'] = $end_date;

                $query .= ' A.created_at between :start_date and :end_date ';
            }
            $query .= ' GROUP BY E.uuid, E.store_name, E.branch';

            $results = DB::select($query, $bindings);

            return response()->json([
                'data' => $results,
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'is_error' => true,
                'message' => 'Error fetching report summary for',
                'error' => $exception->getMessage(),
            ], status: 400);
        }
    }
}
