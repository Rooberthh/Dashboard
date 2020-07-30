<?php


    namespace App\Models;


    use Illuminate\Database\Eloquent\Model;

    class Calendar extends Model
    {
        protected $fillable = ['google_id', 'name', 'color', 'timezone'];

        public function owner()
        {
            return $this->belongsTo(User::class);
        }

        public function events()
        {
            return $this->hasMany(Event::class);
        }
    }
