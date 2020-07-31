<?php


    namespace App\Models;


    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Model;

    class Event extends Model
    {
        protected $with = ['calendar'];
        protected $fillable = ['google_id', 'name', 'description', 'allday', 'started_at', 'ended_at'];

        public function calendar()
        {
            return $this->belongsTo(Calendar::class);
        }

        public function getStartedAtAttribute($start)
        {
            return $this->asDateTime($start)->setTimezone($this->calendar->timezone);
        }

        public function getEndedAtAttribute($end)
        {
            return $this->asDateTime($end)->setTimezone($this->calendar->timezone);
        }

        public function getDurationAttribute()
        {
            return $this->started_at->diffForHumans($this->ended_at, true);
        }

        public function scopeBetweenDates($query, $to, $from)
        {
            return $query->where(['started_at', '<', $to], ['ended_at', '>', $from]);
        }

        public function scopeFromToday($query)
        {
            return $query->where(['started_at', '>=', Carbon::now()]);
        }
    }
