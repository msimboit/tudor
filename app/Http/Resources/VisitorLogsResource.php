<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VisitorLogsResource extends JsonResource
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
            'type' => 'VisitorLogs',
            'attributes' => [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'logger_id' => (string)$this->logger_id,
                'id_number'=> (string)$this->id_number,
                'id_image'=> $this->id_image,
                'destination'=> (string)$this->destination,
                'host'=> (string)$this->host,
                'has_vehicle'=> (string)$this->has_vehicle,
                'vehicle_type'=> (string)$this->vehicle_type,
                'vehicle_number'=> (string)$this->vehicle_number,
                'vehicle_image'=> $this->vehicle_image,
                'created_at' => $this->created_at,
            ]
        ];
    }
}
