<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'overview'     => $this->overview,
            'tagline'      => $this->tagline,
            'release_date' => $this->release_date,
            'reviews'      => ReviewResource::collection($this->whenLoaded('reviews')),
            'reviews_avg' => $this->whenLoaded('reviews', function() {
                return (int)$this->reviews->avg('rating');
            }),
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
        ];
    }
}
