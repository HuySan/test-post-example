<?php

namespace App\DTO;

use Illuminate\Support\Facades\Auth;
use Spatie\LaravelData\Data;

class PostStoreData extends Data
{
    public function __construct(
        public string $title,
        public string $body,
        public ?int $userId,
    )
    {
        $this->userId = Auth::id();
    }
}
