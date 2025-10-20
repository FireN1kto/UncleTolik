<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';

    protected $fillable = ['name_status']; // в БД 'name_status'

    public function records()
    {
        return $this->hasMany(Records::class, 'status_id');
    }

    public function reviews()
    {
        return $this->hasMany(Reviews::class, 'status_id');
    }
}
