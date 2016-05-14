<?php

namespace App\Repositories;

use App\User;

class UserRepository
{
    /**
     * Get all the patients.
     *
     * @param  void
     * @return Collection
     */
    public function patients()
    {
        return User::role('patient')->orderBy('created_at', 'desc')->paginate(10);
    }
    
    /**
     * Get all the operators.
     *
     * @param  void
     * @return Collection
     */
    public function operators()
    {
        return User::role('operator')->orderBy('created_at', 'desc')->paginate(10);
    }
}
