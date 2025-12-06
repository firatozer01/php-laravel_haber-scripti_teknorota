<?php

namespace App\Policies;

use App\Models\Slider;
use App\Models\User;

class SliderPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Slider $slider): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Slider $slider): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Slider $slider): bool
    {
        return $user->isAdmin();
    }
}
