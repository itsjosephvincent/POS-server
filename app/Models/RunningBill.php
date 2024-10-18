<?php

namespace App\Models;

use App\Traits\UsesUuid;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RunningBill extends Model
{
    use Filterable, HasFactory, UsesUuid;

    protected $fillable = [
        'uuid',
        'table_id',
        'product_id',
        'quantity',
        'price',
        'is_voided',
    ];

    protected $casts = [
        'is_voided' => 'boolean',
    ];

    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
