<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectPriceCloset extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var mixed
     */
    protected $fillable = [
        'project_id',
        'price'
    ];

    /**
     * Project
     *
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
