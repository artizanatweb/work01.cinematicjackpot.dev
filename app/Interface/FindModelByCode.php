<?php

namespace App\Interface;

use Illuminate\Database\Eloquent\Model;

interface FindModelByCode
{
    public function findByCode(string $code): ?Model;
}
