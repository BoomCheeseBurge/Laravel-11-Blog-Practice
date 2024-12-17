<?php

namespace App\Traits\File;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasImage
{
    public function uploadImage(UploadedFile $file, string $name, string $fileName): string
    {
        // Store the the uploaded featured image and its filename
        return Storage::disk($name)->putFileAs('/', $file, $fileName . '.' . $file->extension() );
    }
}

?>