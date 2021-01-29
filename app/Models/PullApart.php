<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'final_price',
        'buyer_type',
        'payment_type',
        'bank_id',
        'separation_agreement_at',
        'signature_minute_at',
        'status'
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
     * Get pull aparts only for logged user id.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeOnlyForMe(Builder $query): Builder
    {
        /** @noinspection NullPointerExceptionInspection */
        if(!auth()->user()->hasRole('admin')) {
            return $query->whereHas('visit', function (Builder $q) {
                return $q->where('user_id', auth()->id());
            });
        }

        return $query;
    }
}
