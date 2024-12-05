<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function summary(Request $request)
    {
        try {
            $user = Auth::user();
            $store_id = $user->id;
            $bindings = [];
            $bindings['store_id'] = $store_id;
            $query = 'SELECT COALESCE(SUM(B.price * B.quantity), 0.00) as total_payments, COALESCE(SUM(C.cost * B.quantity), 0.00) as total_cost, COALESCE(SUM(B.price * B.quantity) - SUM(C.cost * B.quantity), 0.00) as total_earnings
            FROM orders as A
            INNER JOIN order_details as B ON A.id=B.order_id INNER JOIN products as C ON B.product_id=C.id INNER JOIN cashiers as D ON A.cashier_id=D.id INNER JOIN stores as E ON D.store_id=E.id
            WHERE E.id = :store_id
            ';

            if ($request->date) {
                $query .= ' AND ';
            }

            if ($request->date) {
                $date = explode(',', $request->date);
                $start_date = $date[0];
                $end_date = $date[1];
                $bindings['start_date'] = $start_date;
                $bindings['end_date'] = $end_date;

                $query .= ' UNIX_TIMESTAMP(A.created_at) BETWEEN :start_date and :end_date ';
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
            $user = Auth::user();
            $store_id = $user->id;
            $bindings = [];
            $bindings['store_id'] = $store_id;
            $query = 'SELECT E.uuid, C.id as product_id, C.name as product_name, B.price, C.cost, SUM(B.quantity)as quantity, SUM(B.price * B.quantity) as sold, SUM(B.price * B.quantity) - SUM(C.cost * B.quantity) as earnings
            FROM orders as A
            INNER JOIN order_details as B ON A.id=B.order_id INNER JOIN products as C ON B.product_id=C.id INNER JOIN cashiers as D ON A.cashier_id=D.id INNER JOIN stores as E ON D.store_id=E.id
            WHERE E.id = :store_id
            ';

            if ($request->date) {
                $query .= ' AND ';
            }

            if ($request->date) {
                $date = explode(',', $request->date);
                $start_date = $date[0];
                $end_date = $date[1];
                $bindings['start_date'] = $start_date;
                $bindings['end_date'] = $end_date;

                $query .= ' UNIX_TIMESTAMP(A.created_at) BETWEEN :start_date and :end_date ';
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
            $user = Auth::user();
            $store_id = $user->id;
            $bindings = [];
            $bindings['store_id'] = $store_id;
            $query = 'SELECT C.category_id, D.name, SUM(B.quantity) as total_quantity, SUM(C.cost * B.quantity) as total_cost, SUM(B.price * B.quantity) as sold, SUM(B.price * B.quantity) - SUM(C.cost * B.quantity) as earnings
            FROM orders as A
            INNER JOIN order_details as B ON A.id=B.order_id INNER JOIN products as C ON B.product_id=C.id
            INNER JOIN categories as D ON D.id=C.category_id INNER JOIN cashiers as E ON A.cashier_id=E.id INNER JOIN stores as F ON E.store_id=F.id
            WHERE F.id = :store_id
            ';

            if ($request->date) {
                $query .= ' AND ';
            }
            if ($request->date) {
                $date = explode(',', $request->date);
                $start_date = $date[0];
                $end_date = $date[1];
                $bindings['start_date'] = $start_date;
                $bindings['end_date'] = $end_date;

                $query .= ' UNIX_TIMESTAMP(A.created_at) BETWEEN :start_date and :end_date ';
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
            $user = Auth::user();
            $store_id = $user->id;
            $bindings = [];
            $bindings['store_id'] = $store_id;
            $query = 'SELECT E.uuid, E.store_name, E.branch, SUM(B.quantity)as quantity, SUM(B.price * B.quantity) as sold, SUM(B.price * B.quantity) - SUM(C.cost * B.quantity) as earnings
            FROM orders as A
            INNER JOIN order_details as B ON A.id=B.order_id INNER JOIN products as C ON B.product_id=C.id INNER JOIN cashiers as D ON A.cashier_id=D.id INNER JOIN stores as E ON D.store_id=E.id
            WHERE E.id = :store_id
            ';

            if ($request->date) {
                $query .= ' WHERE ';
            }
            if ($request->date) {
                $date = explode(',', $request->date);
                $start_date = $date[0];
                $end_date = $date[1];
                $bindings['start_date'] = $start_date;
                $bindings['end_date'] = $end_date;

                $query .= ' UNIX_TIMESTAMP(A.created_at) BETWEEN :start_date and :end_date ';
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

    public function item_sales(Request $request)
    {
        try {
            $user = Auth::user();
            $store_id = $user->id;
            $bindings = [];
            $bindings['store_id'] = $store_id;
            $query = DB::table('orders AS A')
            ->join('order_details AS B', 'A.id', '=', 'B.order_id')
            ->join('products AS C', 'B.product_id', '=', 'C.id')
            ->join('cashiers AS D', 'A.cashier_id', '=', 'D.id')
            ->join('stores AS E', 'D.store_id', '=', 'E.id')
            ->selectRaw('
                C.id,
                C.name,
                SUM(B.quantity) AS items_sold,
                SUM(B.price * B.quantity) AS net_sales,
                SUM(C.cost * B.quantity) AS cogs,
                SUM(B.price * B.quantity) - SUM(C.cost * B.quantity) AS gross_profit
            ');

            $where = ' E.id = :store_id ';
            if ($request->date) {
                $where .= ' AND ';
            }
            if ($request->date) {
                $date = explode(',', $request->date);
                $start_date = $date[0];
                $end_date = $date[1];
                $bindings['start_date'] = $start_date;
                $bindings['end_date'] = $end_date;

                $where .= ' UNIX_TIMESTAMP(A.created_at) BETWEEN :start_date AND :end_date ';
            }

            $results = $query->whereRaw($where, $bindings)
            ->groupBy(['C.id', 'C.name'])
            ->orderBy('gross_profit', 'DESC')
            ->paginate(config('paginate.page'));

            return response()->json($results, 200);
        } catch (\Exception $exception) {
            return response()->json([
                'is_error' => true,
                'message' => 'Error fetching report summary',
                'error' => $exception->getMessage(),
            ], status: 400);
        }
    }

    public function cashier_sales(Request $request)
    {
        try {
            $user = Auth::user();
            $store_id = $user->id;
            $bindings = [];
            $bindings['store_id'] = $store_id;
            $query = DB::table('orders AS A')
            ->join('order_details AS B', 'A.id', '=', 'B.order_id')
            ->join('products AS C', 'B.product_id', '=', 'C.id')
            ->join('cashiers AS D', 'A.cashier_id', '=', 'D.id')
            ->join('stores AS E', 'D.store_id', '=', 'E.id')
            ->selectRaw('
                D.id, D.name,
                SUM(B.quantity) AS items_sold,
                SUM(B.price * B.quantity) AS net_sales,
                SUM(C.cost * B.quantity) AS cogs,
                SUM(B.price * B.quantity) - SUM(C.cost * B.quantity) AS gross_profit
            ');

            $where = ' E.id = :store_id ';
            if ($request->date) {
                $where .= ' AND ';
            }
            if ($request->date) {
                $date = explode(',', $request->date);
                $start_date = $date[0];
                $end_date = $date[1];
                $bindings['start_date'] = $start_date;
                $bindings['end_date'] = $end_date;

                $where .= ' UNIX_TIMESTAMP(A.created_at) BETWEEN :start_date AND :end_date ';
            }

            $results = $query->whereRaw($where, $bindings)
            ->groupBy(['D.id', 'D.name'])
            ->orderBy('gross_profit', 'DESC')
            ->paginate(config('paginate.page'));

            return response()->json($results, 200);
        } catch (\Exception $exception) {
            return response()->json([
                'is_error' => true,
                'message' => 'Error fetching report summary',
                'error' => $exception->getMessage(),
            ], status: 400);
        }
    }

    public function category_sales(Request $request)
    {
        try {
            $user = Auth::user();
            $store_id = $user->id;
            $bindings = [];
            $bindings['store_id'] = $store_id;
            $query = DB::table('orders AS A')
            ->join('order_details AS B', 'A.id', '=', 'B.order_id')
            ->join('products AS C', 'B.product_id', '=', 'C.id')
            ->join('cashiers AS D', 'A.cashier_id', '=', 'D.id')
            ->join('stores AS E', 'D.store_id', '=', 'E.id')
            ->join('categories AS F', 'C.category_id', '=', 'F.id')
            ->selectRaw('
                F.id, F.name,
                SUM(B.quantity) AS items_sold,
                SUM(B.price * B.quantity) AS net_sales,
                SUM(C.cost * B.quantity) AS cogs,
                SUM(B.price * B.quantity) - SUM(C.cost * B.quantity) AS gross_profit
            ');

            $where = ' E.id = :store_id ';
            if ($request->date) {
                $where .= ' AND ';
            }
            if ($request->date) {
                $date = explode(',', $request->date);
                $start_date = $date[0];
                $end_date = $date[1];
                $bindings['start_date'] = $start_date;
                $bindings['end_date'] = $end_date;

                $where .= ' UNIX_TIMESTAMP(A.created_at) BETWEEN :start_date AND :end_date ';
            }

            $results = $query->whereRaw($where, $bindings)
            ->groupBy(['F.id', 'F.name'])
            ->orderBy('gross_profit', 'DESC')
            ->paginate(config('paginate.page'));

            return response()->json($results, 200);
        } catch (\Exception $exception) {
            return response()->json([
                'is_error' => true,
                'message' => 'Error fetching report summary',
                'error' => $exception->getMessage(),
            ], status: 400);
        }
    }
}
