<?php

namespace App\Models;

use database\Masters;
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
        'service_id',
        'master_id',
        'status_id',
    ];

    protected $attributes = [
        'status_id' => 1
    ];

    protected $casts = [
        'date_time' => 'datetime',
    ];
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function services(){
        return $this->belongsTo(Services::class, 'service_id');
    }
    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }
    public function master()
    {
        return $this->belongsTo(Masters::class, 'records_id');
    }
}
