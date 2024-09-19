<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => UserRole::class,
    ];

    /**
     * Create a new personal access token for the user.
     */
    public function createToken(?string $name = null, array $abilities = ['*']): NewAccessToken
    {
        $accessToken = $this->tokens()->create([
            'name' => $name,
            'token' => hash('sha256', $plainTextToken = str()->random(80)),
            'abilities' => $abilities,
            'meta' => [
                'user_agent' => request()->userAgent(),
                'ips' => request()->ips(),
                'ip' => request()->getClientIp(),
            ],
            'expires_at' => now()->addDays(90),
            //'expires_at' => now()->addDays(setting(Setting::TOKEN_DEFAULT_EXPIRATION, 90)),
        ]);

        return new NewAccessToken($accessToken, $plainTextToken);
    }
}
