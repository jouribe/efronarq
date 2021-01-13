<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitCloset extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'visit_id',
        'project_closet_id'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * Visit
     *
     * @return BelongsTo
     */
    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class);
    }

    /**
     * Project closet.
     *
     * @return BelongsTo
     */
    public function closet(): BelongsTo
    {
        return $this->belongsTo(ProjectCloset::class, 'project_closet_id', 'id');
    }
}
