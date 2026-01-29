<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'status',
        'total_amount',
        'base_price',
        'monogram_price',
        'shipping_price',
        'leather_option_id',
        'hardware_option_id',
        'monogram',
        'customer_email',
        'customer_first_name',
        'customer_last_name',
        'customer_phone',
        'shipping_address',
        'shipping_city',
        'shipping_zip_code',
        'shipping_country',
        'shipping_method',
        'billing_address',
        'billing_city',
        'billing_zip_code',
        'billing_country',
        'payment_method',
        'payment_status',
        'card_last_four',
        'card_brand',
        'send_receipt',
        'newsletter_subscription',
        'terms_accepted',
        'estimated_production_days',
        'production_start_date',
        'production_end_date',
        'shipped_date',
        'delivered_date',
        'notes'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'base_price' => 'decimal:2',
        'monogram_price' => 'decimal:2',
        'shipping_price' => 'decimal:2',
        'send_receipt' => 'boolean',
        'newsletter_subscription' => 'boolean',
        'terms_accepted' => 'boolean',
        'production_start_date' => 'date',
        'production_end_date' => 'date',
        'shipped_date' => 'date',
        'delivered_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leatherOption()
    {
        return $this->belongsTo(LeatherOption::class);
    }

    public function hardwareOption()
    {
        return $this->belongsTo(HardwareOption::class);
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class)->orderBy('created_at', 'desc');
    }

    public function paymentLogs(): HasMany
    {
        return $this->hasMany(PaymentLog::class);
    }

    public function generateOrderNumber(): string
    {
        $prefix = 'VRD-';
        $year = date('Y');
        $random = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        
        return "{$prefix}{$random}-{$year}";
    }

    public function calculateTotal(): float
    {
        $total = $this->base_price;
        
        if ($this->leatherOption) {
            $total += $this->leatherOption->price_modifier;
        }
        
        if ($this->hardwareOption) {
            $total += $this->hardwareOption->price_modifier;
        }
        
        $total += $this->monogram_price;
        $total += $this->shipping_price;
        
        return $total;
    }
}