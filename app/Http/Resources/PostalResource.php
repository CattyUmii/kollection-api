<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "address_id" => $this->address_id,
            "code" => $this->code,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
