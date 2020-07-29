<?php

namespace App\Policies;

use App\Models\Board;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BoardPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function manage(User $user, Board $board)
    {
        return $user->is($board->owner);
    }

    public function update(User $user, Board $board)
    {
        return $user->is($board->owner) || $board->members->contains($user);
    }
}
