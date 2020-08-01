<?php


    namespace App\Models;

    use http\Client\Response;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;

    class Board extends Model
    {
        protected $fillable = [
            'name',
            'archived',
            'user_id'
        ];

        protected $with = [
            'statuses'
        ];

        protected $casts = [
            'archived' => 'boolean'
        ];

        protected static function boot()
        {
            parent::boot();

            Board::deleted(function($board){
                $board->statuses->each->delete();
            });
        }

        public function owner()
        {
            return $this->belongsTo(User::class);
        }

        public function statuses()
        {
            return $this->hasMany(Status::class)->orderBy('order')->orderBy('updated_at', 'desc');
        }

        public function members()
        {
            return $this->belongsToMany(User::class, 'board_members')->withTimestamps();
        }

        public function invite(User $user)
        {
            return $this->members()->attach($user);
        }

        public function deleteMember($user)
        {
            return DB::table('board_members')->select('*')->where(['board_id' => $this->id], ['user_id' => $user])->delete();
        }

        public function path()
        {
            return "api/boards/$this->id";
        }
    }
