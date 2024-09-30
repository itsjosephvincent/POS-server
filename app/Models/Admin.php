<?php

namespace App\Models;

use App\Traits\UsesUuid;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Model
{
    use Filterable, HasApiTokens, HasFactory, HasRoles, UsesUuid;

    protected $guard_name = 'web';

    protected $fillable = [
        'uuid',
        'firstname',
        'lastname',
        'username',
        'password',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function stores(): HasMany
    {
        return $this->hasMany(Store::class);
    }
}
