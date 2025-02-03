<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        $data = parent::toArray($request);
//        unset($data['updated_at']);
//        return $data;
        return [
            'id' => $this->id,
            'city' => $this->city,
            'params' => ParamResource::collection($this->params),
        ];
    }
}
