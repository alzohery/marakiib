<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray($request)
    {
        $locale = $request->header('Accept-Language', 'en');

        return [
            'id' => $this->id,
            'car_id' => $this->car_id,
            'car_name' => $this->car->translations->where('locale', $locale)->first()->name ?? $this->car->model,
            'user_id' => $this->user_id,
            'customer_name' => $this->customer->name ?? null,
            'customer_avatar' => $this->customer->avatar ?? null,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'created_at' => $this->created_at,
            'is_active' => $this->is_active,
        ];
    }
}
