<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessResource extends JsonResource
{
    public string $message = "";

    public function __construct(string $message)
    {
        parent::__construct(['message' => $message]);
        $this->message = $message;
    }

    public function with($request): array
    {
        return [
            'message' => $this->message,
        ];
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
