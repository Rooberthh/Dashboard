<?php

    namespace App\Models;

use App\Jobs\SynchronizeGoogleCalendars;
use App\Jobs\WatchGoogleCalendars;
use App\Traits\Synchronizable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Socialite\Facades\Socialite;

class User extends Authenticatable
{
    use Notifiable, Synchronizable;

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

    public function boards()
    {
        return $this->hasMany(Board::class, 'user_id');
    }

    public function calendars()
    {
        return $this->hasMany(Calendar::class);
    }

    public function events()
    {
        return $this->hasManyThrough(Event::class, Calendar::class);
    }

    public function synchronize()
    {
        SynchronizeGoogleCalendars::dispatch($this);
    }

    public function watch()
    {
        WatchGoogleCalendars::dispatch($this);
    }

    public function accessibleBoards()
    {
        return Board::where('user_id', $this->id)
            ->orWhereHas('members', function ($query) {
                $query->where('user_id', $this->id);
            })
            ->get();
    }
}
