<?php

namespace App\Policies;

use App\Models\MenusDishes;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MenusDishesPolicy
{
    public function delete(User $user, MenusDishes $menusDishes): bool
    {
        return $user->id === $menusDishes->menu->user_id;
    }
}
