<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class CartFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function cashier($cashier)
    {
        return $this->whereHas('cashier', function ($query) use ($cashier) {
            $query->where('uuid', $cashier);
        });
    }
}
