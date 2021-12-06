<?php

namespace App\Policies;

use App\Models\ProductList;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductListPolicy
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
     /**
     * Check if the user is Admin
     *
     * @param [type] $user
     * @param [type] $ability
     * @return void
     */
    public function before($user, $ability)
    {
        if ($user->proles->first()->slug == 'admin') {
            return true;
        }
    }

    /**
     * Determine whether the user can view any posts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function view(User $user, ProductList $post)
    {
        //
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->roles->contains('slug', 'content-editor')) {
            return true;
        }elseif($user->permissions->contains('slug', 'create')){
            return true;
        }
        return false;
    }

    /**
     * Undocumented function
     *
     * @param User $user
     * @param Post $post
     * @return void
     */
    public function edit(User $user, ProductList $post)
    {
        if($user->permissions->contains('slug', 'edit')) {
            return true;
        } elseif ($user->roles->contains('slug', 'content-editor')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function update(User $user, ProductList $post)
    {
        if($user->roles->contains('slug', 'content-editor')){
            return true;
        } elseif($user->permissions->contains('slug', 'edit')) {
            return true;
        } elseif($post->userId == $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function delete(User $user, ProductList $post)
    {
        if($user->permissions->contains('slug', '-delete')) {
         
            return true;
        } elseif ($user->roles->contains('slug', 'content-editor')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function restore(User $user, ProductList $post)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function forceDelete(User $user, ProductList $post)
    {
        //
    }
}
