<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{

    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'price_at_purchase' => $this->price_at_purchase,

            'order' => new OrderResource($this->whenLoaded('order')),
            'product' => new ProductResource($this->whenLoaded('product')),

        ];
    }
}
