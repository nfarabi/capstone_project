<?php

namespace App\Traits;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\Services\SlugService;

trait Slugify
{
    use Sluggable;

    public static function bootSlugify()
    {
        static::slugging(function ($model) {
            if (!$model->exists && !empty($model->slug) || $model->exists && $model->isDirty('slug') && !empty($model->slug)) {
                $model->slug = SlugService::createSlug($model, 'slug', $model->slug);
            }
        });
    }

    public function replicate(array $except = null)
    {
        return parent::replicate($except);
    }
}
