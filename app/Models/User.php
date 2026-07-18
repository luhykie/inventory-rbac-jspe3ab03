<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class)
            ->withTimestamps();
    }

    /**
     * Determine if the user's role has the given permission slug.
     */
    public function hasPermission(string $slug): bool
    {
        // System Administrator always has access.
        if ($this->hasRole('system-administrator')) {
            return true;
        }

        // Check permissions assigned directly to the user.
        if (
            $this->permissions()
                ->where('slug', $slug)
                ->exists()
        ) {
            return true;
        }

        // Check permissions inherited from the role.
        return $this->role?->permissions()
            ->where('slug', $slug)
            ->exists() ?? false;
    }

    /**
     * Determine if the user has the given role slug.
     */
    public function hasRole(string $slug): bool
    {
        return $this->role?->slug === $slug;
    }
}