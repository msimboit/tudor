<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatsResource extends JsonResource
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
            'type' => 'Chats',
            'attributes' => [
                'sender_email' => (string)$this->sender_email,
                'receiver_email' => $this->receiver_email,
                'message' => $this->message,
            ]
        ];
    }
}
