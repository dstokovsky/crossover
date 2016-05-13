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
        return User::role('patient')->get();
    }
    
    /**
     * Get all the operators.
     *
     * @param  void
     * @return Collection
     */
    public function operators()
    {
        return User::role('operator')->get();
    }
}
