<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LeavesResource extends JsonResource
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
            'id' => (string)$this->id,
            'type' => 'Leaves',
            'attributes' => [
                'phone_number' => (string)$this->phone_number,
                'first_name' => $this->first_name,
                'email' => $this->email,
                'leaveIssue' => $this->leaveIssue,
                'approved' => (string)$this->approved,
                'cleared' => (string)$this->cleared,
                'created_at' => $this->created_at,
            ]
        ];
    }
}
