<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Records extends Model
{
    protected $table = 'records';
    public $timestamps = false;
    protected $fillable = [
        'surname',
        'name',
        'patronymic',
        'number',
        'date_time',
        'user_id',
        'sevices_id',
        'status_id',
    ];

    protected $casts = [
        'date_time' => 'datetime:Y-m-d-H:i',
    ];
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function services(){
        return $this->belongsTo(Services::class, 'services_id');
    }
    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }
}
