<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'total' => $this->total,
            'created_at' => $this->created_at,

            'user' => new UserResource($this->whenLoaded('user')),

            'cart_items' => CartItemResource::collection($this->whenLoaded('cartItems')),
        ];

        // return parent::toArray($request);
    }
}
