<?php

namespace App\Repositories;

use App\User;

class ReportRepository
{
    /**
     * Get all of the tasks for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function all(User $user)
    {
        return $user->reports()->orderBy('created_at', 'desc')->get();
    }
}
