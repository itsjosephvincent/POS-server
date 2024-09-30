<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class StoreFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function storeName($name)
    {
        return $this->where('store_name', 'LIKE', "%$name%");
    }

    public function branch($branch)
    {
        return $this->where('branch', 'LIKE', "%$branch%");
    }

    public function username($username)
    {
        return $this->where('username', 'LIKE', "%$username%");
    }
}
