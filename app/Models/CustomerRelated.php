<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerRelated extends Model
{
    /**
     * The table associated with the model.
     *
     * @var mixed
     */
    protected $table = 'customer_relates';

    /**
     * The attributes that are mass assignable.
     *
     * @var mixed
     */
    protected $fillable = [
        'customer_id',
        'customer_related_id',
        'type',
        'partner_type',
        'part_one',
        'part_two',
        'document_nro',
        'document'
    ];

    /**
     * Customer.
     *
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
