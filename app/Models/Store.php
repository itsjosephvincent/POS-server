<?php

namespace App\Models;

use App\Traits\UsesUuid;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Store extends Model
{
    use Filterable, HasApiTokens, HasFactory, HasRoles, UsesUuid;

    protected $guard_name = 'web';

    protected $fillable = [
        'uuid',
        'admin_id',
        'store_name',
        'branch',
        'username',
        'password',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function cashiers(): HasMany
    {
        return $this->hasMany(Cashier::class);
    }

    public function tables(): HasMany
    {
        return $this->hasMany(Table::class);
    }
}
