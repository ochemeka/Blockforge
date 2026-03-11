<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
        'country',
        'state',
        'referral_code',
        'referred_by',
        'google_id',
        'google2fa_secret',
        'two_factor_enabled',
        'two_factor_enabled_at',
        'last_login_at',
        'last_login_ip',
        'mining_balance',
        'total_mined',
        'last_mined_at',
        'next_mining_available_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google2fa_secret',
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
            'two_factor_enabled' => 'boolean',
            'two_factor_enabled_at' => 'datetime',
            'last_login_at' => 'datetime',
            'last_mined_at' => 'datetime',
            'next_mining_available_at' => 'datetime',
            'mining_balance' => 'decimal:2',
            'total_mined' => 'decimal:2',
        ];
    }
}
