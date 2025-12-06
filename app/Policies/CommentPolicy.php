<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Comment $comment): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Comment $comment): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Comment $comment): bool
    {
        return $user->isAdmin();
    }
}
