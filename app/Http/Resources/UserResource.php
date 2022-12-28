<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ( $this->access_token && $this->token_type ) {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'access_token' => $this->access_token,
                'token_type' => $this->token_type
            ];
        }else {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'is_admin' => $this->is_admin,
                'visible' => $this->visible,
                'banDateLimit' => $this->ban_date_limit,
                'profile' => asset("uploads/profiles").'/'.$this->profile
            ];
        }
        
    }
}
