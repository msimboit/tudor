<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShiftsResource extends JsonResource
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
            'type' => 'Shifts',
            'attributes' => [
                'phone_number' => (string)$this->phone_number,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'clockin' => $this->clockin,
                'clockout' => $this->clockout,
                'shift_duration' => $this->shift_duration,
                'created_at' => $this->created_at,
            ]
        ];
    }
}
