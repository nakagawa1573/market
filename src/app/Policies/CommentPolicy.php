<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function destroy(User $user, Comment $comment_id)
    {
        return $user->id === $comment_id->user_id;
    }
}
