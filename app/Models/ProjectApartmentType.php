<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectApartmentType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var mixed
     */
    protected $fillable = [
        'project_id',
        'type_name',
        'roofed_area',
        'free_area',
        'bedroom',
        'bathroom',
        'view',
        'blueprint',
        'service_room'
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
     * Price apartments.
     *
     * @return HasMany
     */
    public function priceApartments(): HasMany
    {
        return $this->hasMany(ProjectPriceApartment::class);
    }

    /**
     * Project apartment.
     *
     * @return HasMany
     */
    public function apartments(): HasMany
    {
        return $this->hasMany(ProjectApartment::class);
    }
}
