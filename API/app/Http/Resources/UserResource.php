<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public $token;

    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->token = $this->createToken('auth-token', $this->roles()->pluck('name')->toArray())->plainTextToken;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'email' => $this->email,
            'roles' => $this->roles()->pluck('name')->toArray(),
            'token' => $this->createToken('auth-token', $this->roles()->pluck('name')->toArray())->plainTextToken
        ];
    }
}
