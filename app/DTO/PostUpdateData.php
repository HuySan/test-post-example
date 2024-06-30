<?php

namespace App\DTO;

use Illuminate\Support\Facades\Auth;
use Spatie\LaravelData\Data;

class PostUpdateData extends Data
{
    public function __construct(
        public string $title,
        public string $body,
    )
    {
        //
    }
}
