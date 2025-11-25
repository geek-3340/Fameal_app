<?php

namespace App\Policies;

use App\Models\Dishes;
use App\Models\User;

class DishesPolicy
{
    public function update(User $user, Dishes $dishes): bool
    {
        return $user->id === $dishes->user_id;
    }

    public function delete(User $user, Dishes $dishes): bool
    {
        return $user->id === $dishes->user_id;
    }
}
