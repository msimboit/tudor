<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QrCodesResource extends JsonResource
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
            'type' => 'QrCodes',
            'attributes' => [
                'name' => $this->name,
                'code' => $this->code,
                'user_id' => (string)$this->user_id,
            ]
        ];
    }
}
