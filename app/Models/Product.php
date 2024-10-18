<?php

namespace App\Models;

use App\Traits\UsesUuid;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use Filterable, HasFactory, InteractsWithMedia, UsesUuid;

    protected $fillable = [
        'uuid',
        'category_id',
        'name',
        'image',
        'cost',
        'price',
        'inventory',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('products-media')
            ->useDisk('public');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function admin($admin)
    {
        return $this->whereHas('category.admin', function ($query) use ($admin) {
            $query->where('uuid', $admin);
        });
    }
}
