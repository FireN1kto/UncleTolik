<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Masters extends Model
{
    protected $table = 'masters';
    protected $fillable = [
        'surname',
        'name',
        'patronymic',
        'biography',
        'works_id',
        'records_id'
    ];

    public function records(){
        return $this->hasMany(Records::class, 'records_id');
    }
    public function works(){
        return $this->belongsTo(Works::class, 'works_id');
    }
}
