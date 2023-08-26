<?php

namespace App\Services;

use App\Models\Adress;

class AdressService
{
    public function createAdress(array $data): Adress {
        return Adress::create($data);
    }
}