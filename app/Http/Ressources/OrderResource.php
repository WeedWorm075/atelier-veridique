<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'status' => $this->status,
            'total_amount' => $this->total_amount,
            'customer' => [
                'email' => $this->customer_email,
                'name' => $this->customer_full_name,
                'phone' => $this->customer_phone,
            ],
            'shipping_address' => $this->formatted_shipping_address,
            'payment_status' => $this->payment_status,
            'payment_method' => $this->payment_method,
            'timeline' => [
                'created_at' => $this->created_at,
                'estimated_delivery' => $this->production_start_date 
                    ? $this->production_start_date->addDays($this->estimated_production_days)
                    : null,
                'production_start_date' => $this->production_start_date,
                'production_end_date' => $this->production_end_date,
                'shipped_date' => $this->shipped_date,
                'delivered_date' => $this->delivered_date,
            ],
            'options' => [
                'leather' => $this->leatherOption,
                'hardware' => $this->hardwareOption,
                'monogram' => $this->monogram,
            ],
            'links' => [
                'self' => route('orders.show', $this),
            ],
        ];
    }
}