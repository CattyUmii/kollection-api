<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "email" => $this->email,
            "address" => new AddressResource($this->whenLoaded("address")),
            "articles" => new ArticleCollection($this->whenLoaded("articles")),
            "roles" => RoleResource::collection($this->whenLoaded("roles")),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
