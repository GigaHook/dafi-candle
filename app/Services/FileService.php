<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
        $path = Storage::disk('images')->put($filename, $file);
        $file = '/upload/images/'.$path;
    }

    public function deleteImage(string $path): void {
        Storage::delete('/upload/images/'.$path);
    }
    //TODO ебля с файлами, переделать ато сохраняет в папку с именеем файла внутри которой файл лол чзх wtf
}