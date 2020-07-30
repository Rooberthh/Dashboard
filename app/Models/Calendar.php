<?php


    namespace App\Models;


    use App\Jobs\SynchronizeGoogleEvents;
    use Illuminate\Database\Eloquent\Model;

    class Calendar extends Model
    {
        protected $fillable = ['google_id', 'name', 'color', 'timezone'];

        public static function boot()
        {
            parent::boot();

            static::created(function ($calendar) {
                SynchronizeGoogleEvents::dispatch($calendar);
            });
        }

        public function owner()
        {
            return $this->belongsTo(User::class, 'user_id');
        }

        public function events()
        {
            return $this->hasMany(Event::class);
        }
    }
