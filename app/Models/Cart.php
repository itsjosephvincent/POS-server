<?php

namespace App\Models;

use App\Traits\UsesUuid;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use Filterable, HasFactory, UsesUuid;

    protected $fillable = [
        'uuid',
        'cashier_id',
        'product_id',
        'quantity',
        'price',
        'is_voided',
    ];

    protected $casts = [
        'is_voided' => 'boolean',
    ];

    public function cashier(): BelongsTo
    {
        return $this->belongsTo(Cashier::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
