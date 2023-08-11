<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class FileService
{
    /**
     * загружает файл 
     * заменяет оригинальное значение на путь к файлу
     * @param mixed $file
     * @return string
     */
    public function uploadImage(UploadedFile &$file): void {
        $filename = uniqid().'.'.$file->getClientOriginalExtension();
        Storage::disk('upload')->put($filename, File::get($file));
        $file = $filename;
    }
 
    /**
     * no comment
     * @param string $filename
     * @return void
     */
    public function deleteImage(string $filename): void {
        Storage::disk('upload')->delete($filename);
    }
}