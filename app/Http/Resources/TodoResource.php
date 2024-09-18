<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TodoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'assigned_by'   => $this->assignedBy->name,
            'assigned_to'   => $this->assignedTo->name,
            'title'         => $this->title,
            'description'   => $this->description,
            'status'        => $this->status->value ?? $this->status,
            'image'         => $this->image,
            'due_date'      => $this->due_date,
            'created_at'    => $this->created_at->toDateTimeString(),
            'updated_at'    => $this->updated_at->toDateTimeString(),
        ];
    }
}
