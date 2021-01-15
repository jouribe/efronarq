<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'tax_nro',
        'address',
        'email',
        'phone'
    ];

    /**
     * Customers
     *
     * @return HasMany
     */
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }
}
