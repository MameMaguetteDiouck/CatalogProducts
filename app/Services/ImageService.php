<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageService
{
    protected const UPLOAD_DIR = 'images/products';

    /**
     * Process and store an uploaded product image.
     */
    public static function storeImage(?UploadedFile $file, ?string $oldPath = null): ?string
    {
        if (!$file) {
            return $oldPath;
        }

        // Delete previous image if exists
        if ($oldPath) {
            self::deleteImage($oldPath);
        }

        $destinationPath = public_path(self::UPLOAD_DIR);
        if (!File::isDirectory($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true, true);
        }

        $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $file->move($destinationPath, $filename);

        return self::UPLOAD_DIR . '/' . $filename;
    }

    /**
     * Safely delete an image file from disk.
     */
    public static function deleteImage(?string $path): void
    {
        if (!$path || Str::startsWith($path, ['http://', 'https://', 'data:'])) {
            return;
        }

        $fullPath = public_path($path);
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }
}
