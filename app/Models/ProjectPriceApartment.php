<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectPriceApartment extends Model
{
    /**
     * The attributes that are mass assignable.
     *p
     * @var string[]
     */
    protected $fillable = [
        'project_id',
        'project_apartment_type_id',
        'start_floor',
        'end_floor',
        'price_area'
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
     * Project apartment types
     *
     * @return BelongsTo
     */
    public function apartmentType(): BelongsTo
    {
        return $this->belongsTo(ProjectApartmentType::class);
    }
}
