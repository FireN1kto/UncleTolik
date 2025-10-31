<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'surname',
        'name',
        'patronymic',
        'email',
        'login',
        'password',
        'avatar',
        'role_id',
        'biography'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function records()
    {
        return $this->hasMany(Records::class, 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(Reviews::class, 'user_id');
    }

    public function works()
    {
        return $this->hasMany(Works::class, 'user_id'); // ← добавлено
    }

    public function isAdmin()
    {
        return $this->role && $this->role->name === 'admin';
    }

    public function isMaster()
    {
        return $this->role && $this->role->name === 'master';
    }

    public function isUser()
    {
        return $this->role && $this->role->name === 'user';
    }
}
