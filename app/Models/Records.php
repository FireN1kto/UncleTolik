<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Records extends Model
{
    protected $table = 'records';
    protected $fillable = [
        'surname',
        'name',
        'patronymic',
        'number',
        'date_time',
        'user_id',
        'master_user_id',
        'service_id',
        'is_active'
    ];

    protected $attributes = [
        'is_active' => false
    ];

    protected $casts = [
        'date_time' => 'datetime',
        'is_active' => 'boolean',
    ];
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function service(){
        return $this->belongsTo(Services::class, 'service_id');
    }

    public function master()
    {
        return $this->belongsTo(User::class, 'master_user_id');
    }

    public function review()
    {
        return $this->hasOne(Reviews::class, 'record_id');
    }

}
