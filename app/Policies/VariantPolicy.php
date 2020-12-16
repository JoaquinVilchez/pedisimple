<?php

namespace App\Policies;

use App\User;
use App\Variant;
use Illuminate\Auth\Access\HandlesAuthorization;

class VariantPolicy
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
    
    public function pass(User $user, Variant $variant)
    {
        return $user->restaurant->id == $variant->restaurant_id;
    }
}
