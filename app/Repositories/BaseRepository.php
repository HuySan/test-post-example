<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected string|Model $model;
    protected int $perPage = 10;

    public function __construct()
    {
        $this->setModel();
    }

    abstract protected function setModel();
}
