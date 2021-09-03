<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
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
            'id' => (string)$this->id,
            'type' => 'Users',
            'attributes' => [
                'first_name' => $this->firstname,
                'last_name' => $this->lastname,
                'phone_number' => $this->phone_number,
                'email'=> $this->email,
                'role' => $this->role,
                'created_at' => $this->created_at,
            ]
        ];
    }
}
