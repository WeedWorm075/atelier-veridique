<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeatherOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'color_code',
        'price_modifier',
        'available'
    ];

    protected $casts = [
        'price_modifier' => 'decimal:2',
        'available' => 'boolean'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}