<?php 

namespace  App\Models\Policies\Vendor\RiariForums;

use Illuminate\Support\Facades\Gate;
use Riari\Forum\Models\Thread;
use Auth;

class ThreadPolicyNew
{
    /**
     * Permission: Delete posts in thread.
     *
     * @param  object  $user
     * @param  Thread  $thread
     * @return bool
     */
    public function deletePosts($user, Thread $thread)
    {
        if (Auth::check() && 
        (Auth::user()->hasRole('admin') || Auth::user()->hasRole('pelikulove') || Auth::user()->hasRole('mentor'))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Permission: Rename thread.
     *
     * @param  object  $user
     * @param  Thread  $thread
     * @return bool
     */
    public function rename($user, Thread $thread)
    {
        return $user->getKey() === $thread->author_id;
    }

    /**
     * Permission: Reply to thread.
     *
     * @param  object  $user
     * @param  Thread  $thread
     * @return bool
     */
    public function reply($user, Thread $thread)
    {
        return !$thread->locked;
    }

    /**
     * Permission: Delete thread.
     *
     * @param  object  $user
     * @param  Thread  $thread
     * @return bool
     */
    public function delete($user, Thread $thread)
    {
        return Gate::allows('deleteThreads', $thread->category) || $user->getKey() === $thread->author_id;
    }
}
