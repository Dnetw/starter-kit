<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Dnetw\Admin\Concerns\HasAdminRoles;
use Dnetw\Admin\Concerns\IsRootUser;
use Dnetw\Admin\Contracts\AdminUser;
use Dnetw\Admin\Models\Profile;
use Dnetw\Attachments\Concerns\HasAttachments;
use Dnetw\Comments\Concerns\HasComments;
use Dnetw\Core\Concerns\HasActivities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\PasskeyUser;
use Laravel\Fortify\PasskeyAuthenticatable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable implements AdminUser, PasskeyUser
{
    /** @use HasFactory<UserFactory> */
    use HasActivities, HasAdminRoles, HasAttachments, HasComments, HasFactory, IsRootUser, Notifiable, PasskeyAuthenticatable, TwoFactorAuthenticatable;

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /** @return HasOne<Profile, $this> */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function firstName(): string
    {
        return Str::of($this->name)->before(' ')->toString();
    }
}
