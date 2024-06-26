<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LinkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $redirect = route('red', ['code' => $this->unique_code]);
        if (str_contains($redirect, 'dash.')) {
            $redirect = str_replace('dash.', '', $redirect);
        }
        return [
            // 'id' => $this->id,
            'link' => $this->original_link,
            'short_link' => $redirect,
            'title' => $this->title,
            'code' => $this->unique_code,
            'is_private' => $this->is_private,
            'view_count' => number_format($this->views_count),
            'created_at' => $this->created_at->format('F d Y, H:i'),
            'expire_at' => $this->expire_at->format('F d Y, H:i'),
        ];
    }
}
