<?php

namespace App\Policies;

use App\Models\Ingredients;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class IngredientsPolicy
{
    public function delete(User $user, Ingredients $ingredients): bool
    {
        return $user->id === $ingredients->dish->user_id;
    }
}
