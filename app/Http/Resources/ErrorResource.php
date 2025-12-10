<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class ErrorResource extends JsonResource
{
    public string $message = "";
    public int $status = Response::HTTP_INTERNAL_SERVER_ERROR;

    public function __construct(string $message, ?int $status = null)
    {
        parent::__construct(['message' => $message]);
        $this->message = $message;

        if ($status) {
            $this->status = $status;
        }
    }

    public function with($request): array
    {
        return [
            'message' => $this->message,
        ];
    }

    public function withResponse($request, $response): void
    {
        $response->setStatusCode($this->status);
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
