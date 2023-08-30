<?php

namespace App\Services;

use App\Models\Adress;

class AdressService
{
    public function createAdress(array $data): Adress
    {
        $data['user_id'] = auth()->id();
        return Adress::firstOrCreate($data);
    }
}