<?php 

namespace App\Models\Policies\Vendor\RiariForums;

use Illuminate\Support\Facades\Gate;
use Riari\Forum\Models\Post;
use Auth;

class PostPolicyNew
{
    /**
     * Permission: Edit post.
     *
     * @param  object  $user
     * @param  Post  $post
     * @return bool
     */
    public function edit($user, Post $post)
    {
        return $user->getKey() === $post->author_id;
    }

    /**
     * Permission: Delete post.
     *
     * @param  object  $user
     * @param  Post  $post
     * @return bool
     */
    public function delete($user, Post $post)
    {
        return Gate::forUser($user)->allows('deletePosts', $post->thread) || $user->getKey() === $post->author_id;
    }
}
