<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product_name' => $this->product_name,
            'no_of_stock' => $this->no_of_stock,
            'price' => $this->price,
            'type' => $this->type,
            'product_image' => $this->product_image,
            'description' => $this->description,
            'is_featured' => $this->is_featured,
            
            'category' => new CategoryResource($this->whenLoaded('category')),
            'admin' => new UserResource($this->whenLoaded('admin')),

            'order_items' => OrderItemResource::collection($this->whenLoaded('orderItems')),
            'cart_items' => CartItemResource::collection($this->whenLoaded('cartItems')),

        ];

        // return parent::toArray($request);
    }
}
