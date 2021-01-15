<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PullApart extends Model
{
    use HasFactory;

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
        'amount',
        'amount_at',
        'milestone',
        'fee_balance',
        'fee_balance_at',
        'fee_balance_milestone',
        'afp_amount',
        'afp_amount_at',
        'afp_amount_milestone',
        'mortgage_credit',
        'mortgage_credit_at',
        'mortgage_credit_milestone',
        'separation_agreement_at',
        'signature_minute_at'
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
}
