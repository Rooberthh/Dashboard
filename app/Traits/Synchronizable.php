<?php


    namespace App\Traits;


    use App\Models\Synchronization;

    trait Synchronizable
    {
        public static function bootSynchronizable()
        {
            static::created(function ($synchronizable) {
                $synchronizable->synchronization()->create();
            });

            static::deleting(function ($synchronizable) {
                optional($synchronizable->synchronization)->delete();
            });
        }

        public function synchronization()
        {
            return $this->morphOne(Synchronization::class, 'synchronizable');
        }

        abstract public function synchronize();
    }
