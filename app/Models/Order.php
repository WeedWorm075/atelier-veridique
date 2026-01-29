<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_IN_PRODUCTION = 'in_production';
    const STATUS_SHIPPED = 'shipped';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_CANCELLED = 'cancelled';

    // Payment status constants
    const PAYMENT_STATUS_PENDING = 'pending';
    const PAYMENT_STATUS_PAID = 'paid';
    const PAYMENT_STATUS_FAILED = 'failed';
    const PAYMENT_STATUS_REFUNDED = 'refunded';

    /**
     * Boot the model
     */
    // In Order.php model
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = $order->generateOrderNumber();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function leatherOption(): BelongsTo
    {
        return $this->belongsTo(LeatherOption::class);
    }

    public function hardwareOption(): BelongsTo
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
        $month = date('m');
        $day = date('d');
        $random = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
        
        // More unique order number with date components
        return "{$prefix}{$year}{$month}{$day}{$random}";
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
        
        return round($total, 2);
    }

    /**
     * Update order status with history tracking
     */
    public function updateStatus(string $status, ?string $notes = null): void
    {
        $oldStatus = $this->status;
        $this->status = $status;
        $this->save();

        // Record status change in history
        $this->statusHistory()->create([
            'old_status' => $oldStatus,
            'new_status' => $status,
            'notes' => $notes,
        ]);

        // Update timeline dates based on status
        $this->updateTimelineDates($status);
    }

    /**
     * Update timeline dates based on status
     */
    protected function updateTimelineDates(string $status): void
    {
        $updates = [];
        
        switch ($status) {
            case self::STATUS_IN_PRODUCTION:
                if (!$this->production_start_date) {
                    $updates['production_start_date'] = now()->toDateString();
                }
                break;
                
            case self::STATUS_SHIPPED:
                $updates['shipped_date'] = now()->toDateString();
                // Set production end date if not already set
                if (!$this->production_end_date) {
                    $updates['production_end_date'] = now()->toDateString();
                }
                break;
                
            case self::STATUS_DELIVERED:
                $updates['delivered_date'] = now()->toDateString();
                break;
        }
        
        if (!empty($updates)) {
            $this->update($updates);
        }
    }

    /**
     * Check if order is paid
     */
    public function isPaid(): bool
    {
        return $this->payment_status === self::PAYMENT_STATUS_PAID;
    }

    /**
     * Check if order can be cancelled
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, [
            self::STATUS_PENDING,
            self::STATUS_CONFIRMED,
        ]);
    }

    /**
     * Get formatted customer name
     */
    public function getCustomerFullNameAttribute(): string
    {
        return trim($this->customer_first_name . ' ' . $this->customer_last_name);
    }

    /**
     * Get shipping address as formatted string
     */
    public function getFormattedShippingAddressAttribute(): string
    {
        $parts = [
            $this->shipping_address,
            $this->shipping_city,
            $this->shipping_zip_code,
            $this->shipping_country,
        ];
        
        return implode(', ', array_filter($parts));
    }

    /**
     * Get billing address as formatted string
     */
    public function getFormattedBillingAddressAttribute(): string
    {
        $parts = [
            $this->billing_address,
            $this->billing_city,
            $this->billing_zip_code,
            $this->billing_country,
        ];
        
        return implode(', ', array_filter($parts));
    }

    /**
     * Scope: Get orders by status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: Get orders by payment status
     */
    public function scopePaymentStatus($query, $paymentStatus)
    {
        return $query->where('payment_status', $paymentStatus);
    }

    /**
     * Scope: Get orders for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: Get recent orders
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope: Get orders that need shipping
     */
    public function scopeReadyToShip($query)
    {
        return $query->where('status', self::STATUS_IN_PRODUCTION)
                    ->whereNull('shipped_date');
    }
}