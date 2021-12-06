<?php

namespace App\Policies;


use App\Models\SuperAdmin;
use App\Models\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    
    public function before(SuperAdmin $superadmin, $ability)
    {
       
        if ($superadmin->isAdmin()) {
            return true;
        }
    }

   

    /**
     * Determine whether the user can view the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function view(SuperAdmin $superadmin, Category $category)
    {
        //
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(SuperAdmin $superadmin)
    {
        if ($superadmin->roles->contains('slug', 'content-editor')) {
            return true;
        }elseif($superadmin->permissions->contains('slug', 'create')){
            
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
    public function edit(SuperAdmin $superadmin, Category $category)
    {
        if($superadmin->permissions->contains('slug', 'edit')) {
            return true;
        } elseif ($superadmin->roles->contains('slug', 'content-editor')) {
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
    public function update(SuperAdmin $superadmin, Category $category)
    {
        if($superadmin->roles->contains('slug', 'content-editor')){
            return true;
        } elseif($superadmin->permissions->contains('slug', 'edit')) {
            return true;
        } elseif($category->superadmin_id == $superadmin->id) {
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
    public function delete(SuperAdmin $superadmin, Category $category)
    {
        if($superadmin->permissions->contains('slug', 'delete')) {
            return true;
        } elseif ($superadmin->roles->contains('slug', 'content-editor')) {
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
    public function restore(SuperAdmin $superadmin, Category $category)
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
    public function forceDelete(SuperAdmin $superadmin, Category $category)
    {
        //
    }
}
