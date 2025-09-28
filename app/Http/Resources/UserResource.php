<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        // return parent::toArray($request);
        
        return[
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone_no' => $this->phone_no,
            'address' => $this->address,
            'role' => $this->role,
            // 'full_name' => $this->first_name . ' ' . $this->last_name,
        
            // 'orders' => new OrderResource($this->whenLoaded('orders')),
            'orders' => OrderResource::collection($this->whenLoaded('orders')),
            'cart' => new CartResource($this->whenLoaded('cart')),
            'consultations' => ConsultationResource::collection($this->whenLoaded('consultations')),

            'managed_products' => ProductResource::collection($this->whenLoaded('managedProducts')),
            'managed_orders' => OrderResource::collection($this->whenLoaded('managedOrders')),
            'managed_consultations' => ConsultationResource::collection($this->whenLoaded('managedConsultations')),
            'managed_categories' => CategoryResource::collection($this->whenLoaded('managedCategories')),

            'orders_count' => $this->orders_count ?? 0,

        ];

    }
}
