<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visit extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'project_id',
        'project_apartment_id',
        'origin_id',
        'interested',
        'discount',
        'status',
        'type_financing'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Project.
     *
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Project apartment.
     *
     * @return BelongsTo
     */
    public function apartment(): BelongsTo
    {
        return $this->belongsTo(ProjectApartment::class, 'project_apartment_id', 'id');
    }

    /**
     * Customer
     *
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Tracking
     *
     * @return HasMany
     */
    public function tracking(): HasMany
    {
        return $this->hasMany(VisitTracking::class);
    }

    /**
     * Parking lots
     *
     * @return HasMany
     */
    public function parkingLots(): HasMany
    {
        return $this->hasMany(VisitParkingLot::class);
    }

    /**
     * Closets
     *
     * @return HasMany
     */
    public function closets(): HasMany
    {
        return $this->hasMany(VisitCloset::class);
    }

    /**
     * Origin.
     *
     * @return BelongsTo
     */
    public function origin(): BelongsTo
    {
        return $this->belongsTo(Origin::class);
    }
}
