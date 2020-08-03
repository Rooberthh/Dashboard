<?php


    namespace App\Models;


    use App\Jobs\SynchronizeGoogleEvents;
    use App\Jobs\WatchGoogleEvents;
    use App\Traits\Synchronizable;
    use Illuminate\Database\Eloquent\Model;

    class Calendar extends Model
    {
        use Synchronizable;

        protected $fillable = ['google_id', 'name', 'color', 'timezone'];

        public function owner()
        {
            return $this->belongsTo(User::class, 'user_id');
        }

        public function events()
        {
            return $this->hasMany(Event::class);
        }

        public function synchronize()
        {
            SynchronizeGoogleEvents::dispatch($this);
        }

        public function watch()
        {
            WatchGoogleEvents::dispatch($this);
        }
    }
