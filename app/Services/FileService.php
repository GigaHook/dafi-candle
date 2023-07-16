<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileService
{
    public function uploadImage(mixed $file): string {
        return '/upload/images/'.$this->upload($file, 'images');
    }

    public function uploadTextfile(mixed $file): string {
        return '/upload/textfiles/'.$this->upload($file, 'textfiles');
    }

    private function upload(mixed $file, string $format): string {
        $filename = uniqid().'.'.$file->getClientOriginalExtension();
        Storage::disk($format)->put($filename, file_get_contents($file));
        return $filename;
    }
}