<?php

namespace App\Models;

use App\Traits\UsesUuid;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Table extends Model
{
    use Filterable, HasFactory, UsesUuid;

    protected $fillable = [
        'uuid',
        'store_id',
        'name',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
