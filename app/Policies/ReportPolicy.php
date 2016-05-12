<?php

namespace App\Policies;

use App\User;
use App\Report;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can delete the given report.
     * 
     * @param User $user
     * @param Report $report
     * @return boolean
     */
    public function destroy(User $user, Report $report)
    {
        return $report->user_id === $user->id;
    }
}
