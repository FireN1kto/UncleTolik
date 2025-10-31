<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    protected $table = 'reviews';
    protected $fillable = [
        'surname',
        'name',
        'patronymic',
        'description',
        'user_id',
        'is_active'
    ];

    protected $attributes = [
        'is_active' => false,
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
