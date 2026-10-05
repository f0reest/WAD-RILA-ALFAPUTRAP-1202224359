<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const DEFAULT_EMAIL = 'admin@maintenance-app.test';
    public const DEFAULT_PASSWORD = 'admin123';

    public static function ensureDefaultAdmin(): self
    {
        return static::updateOrCreate(
            ['email' => self::DEFAULT_EMAIL],
            [
                'name' => 'Admin Maintenance',
                'email' => self::DEFAULT_EMAIL,
                'password' => Hash::make(self::DEFAULT_PASSWORD),
            ]
        );
    }

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
