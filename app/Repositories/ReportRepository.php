<?php

namespace App\Repositories;

use App\User;
use App\Report;

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
        return $user->is('operator') ? Report::all() : $user->reports();
    }
}
