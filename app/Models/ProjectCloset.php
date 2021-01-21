<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectCloset extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var mixed
     */
    protected $fillable = [
        'project_id',
        'floor',
        'closet',
        'roofed_area',
        'availability',
        'blueprint',
        'price'
    ];

    /**
     * Project
     *
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Visit closets.
     *
     * @return HasMany
     */
    public function visitCloset(): HasMany
    {
        return $this->hasMany(VisitCloset::class);
    }
}
