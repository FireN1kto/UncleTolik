<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;
    protected $table = 'role';
    protected $fillable = ['name'];

    public function users(){
        return $this->hasMany(User::class,'role_id');
    }
    public static function isUser(): bool
    {
        return static::where('name', 'user')->value('id');
    }
}
