<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class AdminFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function name($name)
    {
        return $this->where(function ($query) use ($name) {
            $query->where('firstname', 'LIKE', "%$name%")
                ->orWhere('lastname', 'LIKE', "%$name%");
        });
    }

    public function email($email)
    {
        return $this->where('email', $email);
    }
}
