<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'total_amount' => $this->total_amount,
            'order_date' => $this->order_date,
            'delivery_date' => $this->delivery_date,
            'home_no' => $this->home_no,
            'street' => $this->street,
            'city' => $this->city,
            'status' => $this->status,

            'customer' => new UserResource($this->whenLoaded('customer')),
            'order_items' => OrderItemResource::collection($this->whenLoaded('orderItems')),
            'payment' => new PaymentResource($this->whenLoaded('payment')),

            'admin' => new UserResource($this->whenLoaded('admin')),
        ];

        // return parent::toArray($request);
    }
}
