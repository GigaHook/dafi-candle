<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileService
{
    public function uploadImage(mixed $file): string {
        $filename = uniqid().'.'.$file->getClientOriginalExtension();
        Storage::disk('images')->put($filename, file_get_contents($file));
        return '/images/'.$filename;
    }
}