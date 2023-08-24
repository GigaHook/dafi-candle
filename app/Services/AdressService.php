<?php

namespace App\Services;

use App\Models\Adress;
use Illuminate\Support\Collection;

class AdressService
{
    public function createAdress(Collection $data) {
        Adress::create($data);
    }
}