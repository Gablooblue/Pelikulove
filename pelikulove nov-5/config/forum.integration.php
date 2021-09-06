<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Policies
    |--------------------------------------------------------------------------
    |
    | Here we specify the policy classes to use. Change these if you want to
    | extend the provided classes and use your own instead.
    |
    */

    'policies' => [
        'forum' => App\Models\Policies\Vendor\RiariForums\ForumPolicyNew::class,
        'model' => [
            Riari\Forum\Models\Category::class  => App\Models\Policies\Vendor\RiariForums\CategoryPolicyNew::class,
            Riari\Forum\Models\Thread::class    => App\Models\Policies\Vendor\RiariForums\ThreadPolicyNew::class,
            Riari\Forum\Models\Post::class      => App\Models\Policies\Vendor\RiariForums\PostPolicyNew::class
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Application user model
    |--------------------------------------------------------------------------
    |
    | Your application's user model.
    |
    */

    'user_model' => App\Models\User::class,

    /*
    |--------------------------------------------------------------------------
    | Application user name
    |--------------------------------------------------------------------------
    |
    | The attribute to use for the username.
    |
    */

    'user_name' => 'name',

];
