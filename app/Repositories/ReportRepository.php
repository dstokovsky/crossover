<?php

namespace App\Repositories;

use App\User;
use App\Report;
use DB;

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
        return $user->is('operator') ? 
            DB::table('reports')
                ->select('users.id AS userId', 'users.name AS userName', 'reports.*')
                ->join('users', 'reports.user_id', '=', 'users.id')
                ->orderBy('reports.created_at', 'desc')
                ->paginate(10) : 
            $user->reports()->paginate(10);
    }
}
