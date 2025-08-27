<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{

    public function toArray($request)
    {
        // return parent::toArray($request);
        return[
            'id' => $this->id,
            'price' => $this->price,
            'quantity' => $this->quantity,

            'cart' => new CartResource($this->whenLoaded('cart')),
            'product' => new ProductResource($this->whenLoaded('product')),
        ];
    }
}
