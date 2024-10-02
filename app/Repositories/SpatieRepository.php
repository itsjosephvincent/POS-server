<?php

namespace App\Repositories;

use App\Interfaces\Repositories\SpatieRepositoryInterface;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SpatieRepository implements SpatieRepositoryInterface
{
    public function delete(object $payload)
    {
        $media = Media::where('model_id', $payload->model_id)
            ->where('model_type', $payload->model_type)
            ->first();

        if ($media) {
            $media->delete();
        }
    }
}
