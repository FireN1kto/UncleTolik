<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Works extends Model
{
    protected $table = 'works';

    protected $fillable = ['image_path'];

    public function master()
    {
        return $this->hasOne(Masters::class, 'works_id');
    }
}
