<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IssuesResource extends JsonResource
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
            'type' => 'Issues',
            'attributes' => [
                'phone_number' => (string)$this->phone_number,
                'first_name' => $this->first_name,
                'title' => $this->title,
                'issueLocation' => $this->issueLocation,
                'details' => $this->details,
                'cleared' => (string)$this->cleared,
                'created_at' => $this->created_at,
            ]
        ];
    }
}
