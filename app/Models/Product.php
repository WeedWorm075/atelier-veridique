<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'base_price',
        'status'
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
    ];

    public function leatherOptions()
    {
        return $this->hasMany(LeatherOption::class);
    }

    public function hardwareOptions()
    {
        return $this->hasMany(HardwareOption::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}