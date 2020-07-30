<?php

    namespace App\Models;

use App\Jobs\SynchronizeGoogleCalendars;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Socialite\Facades\Socialite;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'provider_id', 'token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'token' => 'json'
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            SynchronizeGoogleCalendars::dispatch($user);
        });
    }

    public function boards()
    {
        return $this->hasMany(Board::class);
    }

    public function calendars()
    {
        return $this->hasMany(Calendar::class);
    }

    public function events()
    {
        return $this->hasManyThrough(Event::class, Calendar::class);
    }
}
