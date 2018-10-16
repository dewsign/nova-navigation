<?php

namespace Dewsign\NovaNavigation\Policies;

use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class NavigationPolicy
{
    use HandlesAuthorization;

    public function viewAny()
    {
        return Gate::any(['viewNavigation', 'manageNavigation']);
    }

    public function view($model)
    {
        return Gate::any(['viewNavigation', 'manageNavigation'], $model);
    }

    public function create($user)
    {
        return $user->can('manageNavigation');
    }

    public function update($user, $model)
    {
        return $user->can('manageNavigation', $model);
    }

    public function delete($user, $model)
    {
        return $user->can('manageNavigation', $model);
    }

    public function restore($user, $model)
    {
        return $user->can('manageNavigation', $model);
    }

    public function forceDelete($user, $model)
    {
        return $user->can('manageNavigation', $model);
    }
}
