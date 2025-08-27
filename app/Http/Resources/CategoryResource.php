<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'category_name' => $this->category_name,
            'category_desc' => $this->category_desc,
            'category_image' => $this->category_image,

            'admin' => new UserResource($this->whenLoaded('admin')),
            
            'products' => ProductResource::collection($this->whenLoaded('products')),

        ];

        // return parent::toArray($request);
    }
}
