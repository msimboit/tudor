<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GeolocationResource extends JsonResource
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
            'type' => 'Geolocation',
            'attributes' => [
                'phone_number' => (string)$this->phone_number,
                'latitude' => (string)$this->latitude,
                'longitude' => (string)$this->longitude,
            ]
        ];
    }
}
