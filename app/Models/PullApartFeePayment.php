<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PullApartFeePayment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var mixed
     */
    protected $fillable = [
        'pull_part_fee_id',
        'amount',
        'currency',
        'type',
        'document_nro',
        'ticket',
        'ticket_nro',
        'voucher',
        'late_payment',
        'comment',
        'exchange_rate',
        'payment_at',
        'status'
    ];

    /**
     * Pull apart fee
     *
     * @return BelongsTo
     */
    public function fee(): BelongsTo
    {
        return $this->belongsTo(PullApartFee::class);
    }
}
