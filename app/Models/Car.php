<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'merk',
        'model',
        'photo',
        'plat_number',
        'rental_fee',
        'is_rent',
    ];

    /**
     * Scope a query to only include search
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('plat_number', 'LIKE', '%' . $search . '%')
            ->orWhere('model', 'LIKE', '%' . $search . '%')
            ->orWhere('merk', 'LIKE', '%' . $search . '%');
    }

    /**
     * Scope a query to only include isRent
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsRent($query, $payload)
    {
        return $query->where('is_rent', $payload);
    }
}
