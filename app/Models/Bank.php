<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'contact_name',
        'contact_phone',
        'contact_email',
        'currency',
        'is_active'
    ];

    /**
     * Project
     *
     * @return HasMany
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Pull aparts
     *
     * @return HasMany
     */
    public function pullAparts(): HasMany
    {
        return $this->hasMany(PullApart::class);
    }
}
