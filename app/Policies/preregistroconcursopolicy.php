<?php

namespace App\Policies;

use App\Models\PreRegistroConcurso;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PreRegistroConcursoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any pre-registros.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create pre-registros.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the pre-registro.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PreRegistroConcurso  $preRegistro
     * @return bool
     */
    public function view(User $user, PreRegistroConcurso $preRegistro): bool
    {
        return $user->id === $preRegistro->usuario_id;
    }

    /**
     * Determine whether the user can update the pre-registro.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PreRegistroConcurso  $preRegistro
     * @return bool
     */
    public function update(User $user, PreRegistroConcurso $preRegistro): bool
    {
        return $user->id === $preRegistro->usuario_id;
    }
}