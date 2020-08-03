<?php


    namespace App\Traits;


    use App\Google;
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

        public function getGoogleService($service)
        {
            return app(Google::class)
                ->connectWithSynchronizable($this)
                ->service($service);
        }

        abstract public function synchronize();
        abstract public function watch();
    }
