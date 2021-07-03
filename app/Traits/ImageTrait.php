<?php

namespace App\Traits;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as ImageManager;

trait ImageTrait
{
    public function saveMultipleImages($images, $relatedId, $type = Image::TYPE_BIKE)
    {
        $imageDir = config('constants.image.dir.base');
        $subDir = config('constants.image.dir.' . $type);
        $dir = $imageDir . $subDir . '/' . $relatedId;
        if (is_array($images)) {
            foreach ($images as $image) {
                if ($image['id'] == 0) {
                    $this->createImage(
                        $image,
                        $relatedId,
                        config('constants.image.type.' . $type),
                        $dir
                    );
                } else {
                    $this->updateImage(
                        $image,
                        $relatedId,
                        config('constants.image.type.' . $type),
                        $dir
                    );
                }
            }
        }
    }

    public function createImage($image, $relatedId = 0, $imageType = 'type_bike', $dir = '', $disk = 'public')
    {
        if ($image['image'] == '')
            return;

        $filePath = $this->storeImageFile($image['image'], $dir, $disk);
        $imagePath = $this->getImagePath($filePath);

        Image::create([
            'image_type' => $imageType,
            'is_featured' => $image['is_featured'],
            'file' => $imagePath,
            'related_id' => $relatedId,
        ]);
    }

    public function updateImage($image, $relatedId = 0, $imageType = Image::TYPE_BIKE, $dir = '', $disk = 'public')
    {
        $imageObj = Image::find($image['id']);

        if ($imageObj == null) {
            $this->createImage($image, $relatedId, $imageType, $dir, $disk);
            return;
        }

        if ($image['image'] == '') {
            $this->deleteImageFile($imageObj['file_path']);
            $imageObj->delete();
            return;
        }

        if ($image['image'] != $imageObj['file']) {
            $this->deleteImageFile($imageObj['file_path']);
            $filePath = $this->storeImageFile($image['image'], $dir, $disk);
            $imagePath = $this->getImagePath($filePath);
            $imageObj['file'] = $imagePath;
        }

        $imageObj['is_featured'] = $image['is_featured'];
        $imageObj['image_type'] = $imageType;
        $imageObj->save();
    }

    public function storeImageFile($imageData = '', $dir = '/uploads', $disk = 'public')
    {
        if (!Str::startsWith($imageData, 'data:image'))
            return '';

        $image = ImageManager::make($imageData)->encode('jpg', 90);
        $filename = md5($image . time()) . '.jpg';

        Storage::disk($disk)->put($dir . '/' . $filename, $image->stream());

        return $dir . '/' . $filename;
    }

    public function deleteImageFile($imagePath, $disk = 'public')
    {
        Storage::delete($imagePath);
    }

    protected function getImagePath($filePath)
    {
        return substr($filePath, 8);
    }
}
