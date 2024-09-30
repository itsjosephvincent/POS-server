<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Cashier extends Model
{
    use HasApiTokens, HasFactory, HasRoles, UsesUuid;

    protected $guard_name = 'web';

    protected $fillable = [
        'uuid',
        'store_id',
        'name',
        'username',
        'password',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
