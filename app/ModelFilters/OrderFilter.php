<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class OrderFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function orderNumber($number)
    {
        return $this->where('order_number', $number);
    }

    public function date($date)
    {
        return $this->whereDate('orders.created_at', $date);
    }

    public function store($store_uuid)
    {
        return $this->where('stores.uuid', $store_uuid);
    }
}
