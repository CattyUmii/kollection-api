<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "user_id" => $this->when(isset($this->user_id), $this->user_id),
            "user" => $this->whenLoaded("user"),
            "postal" => new PostalResource($this->whenLoaded("postal")),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
