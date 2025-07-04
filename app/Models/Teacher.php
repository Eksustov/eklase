<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['user_id', 'first_name', 'last_name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
