<?php

namespace App\Models;

use App\Traits\UsesUuid;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    use Filterable, HasFactory, UsesUuid;

    protected $fillable = [
        'uuid',
        'cashier_id',
        'order_number',
        'is_voided',
        'note',
    ];

    protected static function booted()
    {
        static::saving(function ($order) {
            $string = Str::upper(Str::random(3));
            $timestamp = $timestamp = now()->format('ymd').substr((string) microtime(true), -3);
            $order->order_number = $string.$timestamp;
        });
    }

    public function cashier(): BelongsTo
    {
        return $this->belongsTo(Cashier::class);
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }
}
