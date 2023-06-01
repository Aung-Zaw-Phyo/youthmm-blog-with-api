<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->thumbnail) {
            $path = asset("uploads").'/'.$this->thumbnail;
        }else {
            $path = null;
        }

        $comments = CommentResource::collection($this->comments);

        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'category' => $this->category->name,
            'author' => $this->user->name,
            'thumbnail' => $path,
            'createdAt' => $this->created_at->diffForHumans(),
            'comments' => $comments
        ];
    }
}
