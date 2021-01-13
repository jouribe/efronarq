<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'logo',
        'bank_id',
        'legal',
        'status',
        'is_active'
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
        'updated_at',
        'deleted_at'
    ];

    /**
     * Project addresses
     *
     * @return HasMany
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(ProjectAddress::class);
    }

    /**
     * Project apartment types.
     *
     * @return HasMany
     */
    public function apartmentTypes(): HasMany
    {
        return $this->hasMany(ProjectApartmentType::class);
    }

    /**
     * Project prices.
     *
     * @return HasMany
     */
    public function prices(): HasMany
    {
        return $this->hasMany(ProjectPrice::class);
    }

    /**
     * Project apartment prices.
     *
     * @return HasMany
     */
    public function apartmentPrices(): HasMany
    {
        return $this->hasMany(ProjectPriceApartment::class);
    }

    /**
     * Project apartments
     *
     * @return HasMany
     */
    public function apartments(): HasMany
    {
        return $this->hasMany(ProjectApartment::class);
    }

    /**
     * Project parking lots price.
     *
     * @return HasMany
     */
    public function parkingLotPrices(): HasMany
    {
        return $this->hasMany(ProjectPriceParkingLot::class);
    }

    /**
     * Parking lots
     *
     * @return HasMany
     */
    public function parkingLots(): HasMany
    {
        return $this->hasMany(ProjectParkingLot::class);
    }

    /**
     * Project closets.
     *
     * @return HasMany
     */
    public function closets(): HasMany
    {
        return $this->hasMany(ProjectCloset::class);
    }

    /**
     * Project documents.
     *
     * @return HasMany
     */
    public function documents(): HasMany
    {
        return $this->hasMany(ProjectDocument::class);
    }

    /**
     * Bank
     *
     * @return BelongsTo
     */
    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    /**
     * Visits
     *
     * @return HasMany
     */
    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }
}
