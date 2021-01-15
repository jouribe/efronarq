<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visit extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var mixed
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

    /**
     * Quotation
     *
     * @return HasOne
     */
    public function quotation(): HasOne
    {
        return $this->hasOne(VisitQuotation::class, 'visit_id', 'id');
    }

    /**
     * Pull aparts.
     *
     * @return HasMany
     */
    public function pullAparts(): HasMany
    {
        return $this->hasMany(PullApart::class);
    }
}
