<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'payment_method' => $this->payment_method,
            'payment_status' => $this->payment_status,
            'amount' => $this->amount,
            'payment_date' => $this->payment_date,

            'order' => new OrderResource($this->whenLoaded('order')),
        ];

        // return parent::toArray($request);
    }
}
