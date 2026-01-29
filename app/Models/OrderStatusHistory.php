<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model
{
    // indique la table exacte qui existe dans Postgres
    protected $table = 'order_status_history';

    // colonnes modifiables
    protected $fillable = ['order_id', 'status', 'notes'];

    // si tu veux, tu peux laisser les timestamps (created_at/updated_at)
    public $timestamps = true;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
