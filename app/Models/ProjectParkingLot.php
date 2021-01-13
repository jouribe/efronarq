<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectParkingLot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'project_id',
        'floor',
        'parking_lot',
        'roofed_area',
        'free_area',
        'type',
        'availability',
        'address_id',
        'discount',
        'closet',
        'blueprint'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @deprecated Use the "casts" property
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
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
     * Address
     *
     * @return BelongsTo
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(ProjectAddress::class);
    }

    /**
     * Visit parking lot.
     *
     * @return HasMany
     */
    public function visitParkingLot(): HasMany
    {
        return $this->hasMany(VisitParkingLot::class);
    }
}
