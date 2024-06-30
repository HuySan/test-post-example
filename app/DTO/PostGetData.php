<?php

namespace App\DTO;

use Illuminate\Support\Facades\Auth;
use Spatie\LaravelData\Data;

class PostGetData extends Data
{
    public function __construct(
        public string $id,
        public string $title,
        public string $body,
        public ?int $userId,
    )
    {
        $this->userId = $this->userId ?? Auth::id();
        $this->body = substr($this->body, 0, 128);
    }
}
