<?php

/** @noinspection UnknownInspectionInspection */

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visit extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var mixed
     */
    protected $fillable = [
        'customer_id',
        'project_id',
        'user_id',
        'project_apartment_id',
        'origin_id',
        'interested',
        'promotion_id',
        'status',
        'type_financing',
        'exchange_id'
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
     * Promotion
     *
     * @return BelongsTo
     */
    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class);
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
     * User
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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

    /**
     * Seller.
     *
     * @return BelongsTo
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Exchange rate.
     *
     * @return BelongsTo
     */
    public function exchange(): BelongsTo
    {
        return $this->belongsTo(Exchange::class);
    }

    /**
     * Get visits for login user.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeOnlyForMe(Builder $query): Builder
    {
        /** @noinspection NullPointerExceptionInspection */
        if (!auth()->user()->hasRole('admin')) {
            return $query->where('user_id', auth()->id());
        }

        return $query->where('user_id', '>', 0);
    }

    /**
     * Get latest tracking of the pull apart.
     *
     * @param Builder $query
     * @return Builder
     * @noinspection PhpUnused
     */
    public function scopeLatestTracking(Builder $query): Builder
    {
        return $query->whereHas('tracking', function (Builder $q) {
            return $q->latest();
        });
    }
}
