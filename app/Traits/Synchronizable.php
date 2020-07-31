<?php


    namespace App\Traits;


    use App\Models\Synchronization;

    trait Synchronizable
    {
        public static function bootSynchronizable()
        {
            static::created(function ($model) {
                $model->synchronization()->create();
            });

            static::deleting(function ($model) {
                optional($model->synchronization)->delete();
            });
        }

        public function synchronization()
        {
            return $this->morphOne(Synchronization::class, 'synchronizable');
        }

        abstract public function synchronize();
    }
