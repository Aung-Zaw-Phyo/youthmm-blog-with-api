<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'body' => $this->body,
            'createdAt' => $this->created_at->diffForHumans(),
            'user' => $this->user->name,
            'profile' => $this->user->profile ? asset("uploads/profiles").'/'.$this->user->profile : null
        ];
    }
}
