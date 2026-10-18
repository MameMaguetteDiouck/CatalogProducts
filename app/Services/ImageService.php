<?php
namespace App\Services;
use Illuminate\Support\Facades\File;

class ImageService
{
    public static function traitementImg($file, $way)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = time().'.'.$extension;
        $file->move($way, $filename);

        return $way . $filename;
    }

    public static function deleteImg($way): void
    {
        if (File::exists($way)) {
            File::delete($way);
        }
    }
}
