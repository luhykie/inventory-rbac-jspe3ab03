<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* ----------------------------------------------------------
    | RBAC helpers
    * ---------------------------------------------------------- */

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Determine if the user's role has the given permission slug.
     */
    public function hasPermission(string $slug): bool
    {
        if ($this->role === null) {
            return false;
        }

        return $this->role->permissions->contains('slug', $slug);
    }

    /**
     * Determine if the user has the given role slug.
     */
    public function hasRole(string $slug): bool
    {
        return $this->role?->slug === $slug;
    }
}