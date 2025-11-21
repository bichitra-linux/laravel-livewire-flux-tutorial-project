<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\UploadedFile;

class ImageOptimizationService
{
    protected $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Optimize and save uploaded image
     */
    public function optimizeAndSave(UploadedFile $file, string $path, int $maxWidth = 1200): string
    {
        $image = $this->manager->read($file);

        // Resize if larger than max width
        if ($image->width() > $maxWidth) {
            $image->scale(width: $maxWidth);
        }

        // Generate unique filename
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $fullPath = storage_path('app/public/' . $path . '/' . $filename);

        // Ensure directory exists
        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0755, true);
        }

        // Save with optimization
        if ($file->getClientOriginalExtension() === 'jpg' || $file->getClientOriginalExtension() === 'jpeg') {
            $image->toJpeg(quality: 85)->save($fullPath);
        } elseif ($file->getClientOriginalExtension() === 'png') {
            $image->toPng()->save($fullPath);
        } else {
            $image->save($fullPath);
        }

        return $path . '/' . $filename;
    }

    /**
     * Generate thumbnail
     */
    public function createThumbnail(string $imagePath, int $width = 300, int $height = 300): string
    {
        $image = $this->manager->read(storage_path('app/public/' . $imagePath));
        
        $image->cover($width, $height);
        
        $thumbnailPath = str_replace('.', '_thumb.', $imagePath);
        $fullPath = storage_path('app/public/' . $thumbnailPath);
        
        $image->save($fullPath);
        
        return $thumbnailPath;
    }
}