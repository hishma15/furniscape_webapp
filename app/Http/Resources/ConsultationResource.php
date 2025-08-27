<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultationResource extends JsonResource
{

    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'prefered_date' => $this->prefered_date,
            'prefered_time' => $this->prefered_time,
            'status' => $this->status,
            'mode' => $this->mode,
            'topic' => $this->topic,
            'description' => $this->description,
            
            'customer' => new UserResource($this->whenLoaded('customer')),
            'admin' => new UserResource($this->whenLoaded('admin')),
            

        ];
    }
}
