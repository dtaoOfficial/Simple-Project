<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Programme;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProgrammePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Programme');
    }

    public function view(AuthUser $authUser, Programme $programme): bool
    {
        return $authUser->can('View:Programme');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Programme');
    }

    public function update(AuthUser $authUser, Programme $programme): bool
    {
        return $authUser->can('Update:Programme');
    }

    public function delete(AuthUser $authUser, Programme $programme): bool
    {
        return $authUser->can('Delete:Programme');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Programme');
    }

    public function restore(AuthUser $authUser, Programme $programme): bool
    {
        return $authUser->can('Restore:Programme');
    }

    public function forceDelete(AuthUser $authUser, Programme $programme): bool
    {
        return $authUser->can('ForceDelete:Programme');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Programme');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Programme');
    }

    public function replicate(AuthUser $authUser, Programme $programme): bool
    {
        return $authUser->can('Replicate:Programme');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Programme');
    }

}