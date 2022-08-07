<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

trait UploadFile
{
    public function uploadFile($file)
    {
        $extension = $file->getClientOriginalExtension();

        // Generate random file name
        $random_file_name = Str::uuid()->toString();
        $fileName = 'img/' . $random_file_name .'.'.$extension;

        Storage::disk('local')->put($fileName, $file);

        return $fileName;
    }
}
