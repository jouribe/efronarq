<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitQuotation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var mixed
     */
    protected $table = 'visit_quotation';

    /**
     * The attributes that are mass assignable.
     *
     * @var mixed
     */
    protected $fillable = [
        'visit_id',
        'file',
        'mode'
    ];

    /**
     * Visits
     *
     * @return BelongsTo
     */
    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class);
    }
}
