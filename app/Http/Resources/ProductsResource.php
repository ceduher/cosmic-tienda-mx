<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $price = $this->discount_price > 0 ? $this->discount_price : $this->price;
        return [
            "product" => $this,
            "price" => $price,
            "price_format" => getPrice($price),
            "cover" => $this->getFirstMediaUrl('image'),
            "rate" => $tmp2,
            "category" => $this->category,
            "options_groups" => $this->options?->keyBy('name'),
            "isLikedBy" => $likedBy,
        ];
    }
}
