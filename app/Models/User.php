<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * A user can belong to many organizations.
     *
     * @return BelongsToMany
     */
    public function organizations(): BelongsToMany
    {
        // return $this->belongsToMany(Organization::class, 'organization_user')
        return $this->belongsToMany(Organization::class)
                    ->withPivot('role')
                    ->withTimestamps();
    }

    /**
     * A user can have many tasks (many-to-many).
     *
     * @return BelongsToMany
     */
    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class);
    }
}
