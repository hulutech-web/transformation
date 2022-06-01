<?php

namespace App\Policies;

use App\Models\Build;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
class BuildPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        if($user->id===1){
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Build  $build
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Build $build)
    {
        if($user->id===1){
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        if($user->id==1){
            return true;
        }else{
            //否则提示错误
            Response::deny('您没有权限操作');
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Build  $build
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Build $build)
    {

        if($user->id==1){
            return true;
        }else{
            //否则提示错误
            Response::deny('您没有权限操作');
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Build  $build
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Build $build)
    {
        if($user->id==1){
            return true;
        }else{
            //否则提示错误
            Response::deny('您没有权限操作');
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Build  $build
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Build $build)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Build  $build
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Build $build)
    {
        //
    }
}
