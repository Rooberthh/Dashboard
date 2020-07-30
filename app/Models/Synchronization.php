<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Synchronization extends Model
{
    public $incrementing = false;

    protected $fillable = ['token', 'last_synchronized_at'];

    protected $casts = [
      'last_synchronized_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        // Before creating a new synchronization,
        // ensure the UUID and the `last_synchronized_at` are set.
        static::creating(function ($synchronization) {
            $synchronization->id = Uuid::uuid4();
            $synchronization->last_synchronized_at = now();
        });

        // Initial ping.
        static::created(function ($synchronization) {
            $synchronization->ping();
        });
    }

    public function ping()
    {
        return $this->synchronizable->synchronize();
    }

    public function synchronizable()
    {
        return $this->morphTo();
    }
}
