<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'enabled',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the role
     *
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo('App\Role');
    }

    /**
     * Check for at least one role of the array
     *
     * @param array $roles
     * @return bool
     */
    public function hasAnyRoles(array $roles): bool
    {
        if ($this->role()->whereIn('name', $roles)->first()) {
            return true;
        }

        return false;
    }

    /**
     * Check for the role
     *
     * @param string $role
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        if ($this->role()->where('name', $role)->first()) {
            return true;
        }

        return false;
    }
}
