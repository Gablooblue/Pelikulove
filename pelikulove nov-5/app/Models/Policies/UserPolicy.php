<?php

namespace App\Models\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;
    
    public function createCategories(User $user)
    {
        return $user->hasRole(['admin', 'pelikulove', 'mentor', 'user'], true);
    }

    public function view(User $user)
    {
        //
    }
    
    public function create(User $user)
    {
        //
    }
    
    public function update(User $user)
    {
        //
    }

    public function delete(User $user)
    {
        //
    }
    
    public function restore(User $user)
    {
        //
    }
    
    public function forceDelete(User $user)
    {
        //
    }
}
