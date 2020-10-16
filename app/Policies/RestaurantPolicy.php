<?php

namespace App\Policies;

use App\User;
use App\Restaurant;
use Illuminate\Auth\Access\HandlesAuthorization;

class RestaurantPolicy
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

    public function pass(User $user, Restaurant $restaurant)
    {
        return $user->restaurant->id == $restaurant->id;
    }
}
