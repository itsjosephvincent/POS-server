<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class RunningBillFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function table($table)
    {
        return $this->whereHas('table', function ($query) use ($table) {
            $query->where('uuid', $table);
        });
    }
}
