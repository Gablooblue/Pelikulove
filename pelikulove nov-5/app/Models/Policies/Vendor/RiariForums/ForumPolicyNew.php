<?php 

namespace App\Models\Policies\Vendor\RiariForums;

use Auth;
use App\Models\Role;
use App\Models\RoleUser;

class ForumPolicyNew
{
    /**
     * Permission: Create categories.
     *
     * @param  object  $user
     * @return bool
     */
    public function createCategories($user)
    {
        return $this->checkIfValidRole(2);
    }

    /**
     * Permission: Manage category.
     *
     * @param  object  $user
     * @return bool
     */
    public function manageCategories($user)
    {
        return $this->moveCategories($user) ||
               $this->renameCategories($user);
    }

    /**
     * Permission: Move categories.
     *
     * @param  object  $user
     * @return bool
     */
    public function moveCategories($user)
    {
        return $this->checkIfValidRole(2);
    }

    /**
     * Permission: Rename categories.
     *
     * @param  object  $user
     * @return bool
     */
    public function renameCategories($user)
    {
        return $this->checkIfValidRole(2);
    }

    /**
     * Permission: Mark new/updated threads as read.
     *
     * @param  object  $user
     * @return bool
     */
    public function markNewThreadsAsRead($user)
    {
        return true;
    }

    /**
     * Permission: View trashed threads.
     *
     * @param  object  $user
     * @return bool
     */
    public function viewTrashedThreads($user)
    {
        return $this->checkIfValidRole(2);
    }

    /**
     * Permission: View trashed posts.
     *
     * @param  object  $user
     * @return bool
     */
    public function viewTrashedPosts($user)
    {
        return $this->checkIfValidRole(2);
    }
    
    private function checkIfValidRole ($roleID) {
        if (Auth::User()->hasRole('admin') || Auth::User()->hasRole('pelikulove')) {
            return true;
        } else {
            return false;
        }
    }
}
