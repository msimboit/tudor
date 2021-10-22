<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ScannersResource extends JsonResource
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
            'type' => 'Scans',
            'attributes' => [
                'phone_number' => (string)$this->phone_number,
                'first_name' => $this->first_name,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'sector' => $this->sector,
                'sector_name' => $this->sector_name,
                'time' => $this->time,
                'created_at' => $this->created_at,
            ]
        ];
    }
}
