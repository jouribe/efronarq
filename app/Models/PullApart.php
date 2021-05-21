<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PullApart extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var mixed
     */
    protected $fillable = [
        'visit_id',
        'discount_type',
        'discount',
        'buyer_type',
        'payment_type',
        'bank_id',
        'separation_agreement_at',
        'signature_minute_at',
        'final_price',
        'status',
        'agreement',
        'sworn_declaration',
        'is_sale',
        'signed_separation_agreement',
        'agreement_model'
    ];

    /**
     * Pull apart fee.
     *
     * @return HasMany
     */
    public function fees(): HasMany
    {
        return $this->hasMany(PullApartFee::class);
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
     * Visit.
     *
     * @return BelongsTo
     */
    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class);
    }

    /**
     * Comments.
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(PullApartComment::class);
    }

    /**
     * Pull apart documents.
     *
     * @return HasMany
     */
    public function documents(): HasMany
    {
        return $this->hasMany(PullApartDocument::class);
    }

    /**
     * Pull apart bill
     *
     * @return HasMany
     */
    public function bills(): HasMany
    {
        return $this->hasMany(PullApartBill::class);
    }

    /**
     * Pull apart changes
     *
     * @return HasMany
     */
    public function changes(): HasMany
    {
        return $this->hasMany(PullApartChange::class);
    }

    /**
     * Pull apart deliveries
     *
     * @return HasMany
     */
    public function deliveries(): HasMany
    {
        return $this->hasMany(PullApartDelivery::class);
    }

    /**
     * Bill History
     *
     * @return HasMany
     */
    public function billHistory(): HasMany
    {
        return $this->hasMany(PullApartBillHistory::class);
    }

    /**
     * Get pull aparts only for logged user id.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeOnlyForMe(Builder $query): Builder
    {
        /** @noinspection NullPointerExceptionInspection */
        if (!auth()->user()->hasRole('admin')) {
            return $query->whereHas('visit', function (Builder $q) {
                return $q->where('user_id', auth()->id());
            });
        }

        return $query;
    }

    /**
     * Get pull a aparts that are a sale.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeIsASale(Builder $query): Builder
    {
        return $query->where('is_sale', true);
    }

    /**
     * Get pull aparts that are not a sale.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeIsNotASale(Builder $query): Builder
    {
        return $query->where('is_sale', false);
    }

    /**
     * Get pull aparts thar are selectables for sale.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeSelectableForSale(Builder $query): Builder
    {
        return $query->where('is_sale', false)->where('pull_aparts.status', 'Aprobado');
    }
}
