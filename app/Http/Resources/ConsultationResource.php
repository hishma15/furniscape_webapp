<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\UserResource;
use App\Models\User;

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
            
            'customer' => $this->customer_id ? new UserResource(User::find($this->customer_id)) : null,
            'admin' => $this->admin_id ? new UserResource(User::find($this->admin_id)) : null,
            

        ];
    }
}
