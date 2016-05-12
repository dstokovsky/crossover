<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'procedure', 'statement', 'findings', 'impression', 'conclusion'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
