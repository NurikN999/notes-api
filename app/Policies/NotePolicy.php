<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\User;

class NotePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user)
    {
        return $user->is_admin == 1;
    }

    public function create(User $user)
    {
        return true;
    }

    public function delete(User $user, Note $note)
    {
        return $user->is_admin == 1 || $user->id == $note->user_id;
    }

    public function update(User $user, Note $note)
    {
        return $user->is_admin == 1 || $user->id == $note->user_id;
    }
}
