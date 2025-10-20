<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'type';

    protected $fillable = ['name'];

    public function services()
    {
        return $this->hasMany(Services::class, 'type_id');
    }
}
