<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'body' => $this->resource->body,
            'user_name' => $this->user->name,
            'user_avatar' => 'https://cdn-icons-png.flaticon.com/512/149/149071.png',
            'ago' => $this->created_at->diffForHumans(),
            'is_liked' => $this->resource->isLiked(),
        ];
    }
}
