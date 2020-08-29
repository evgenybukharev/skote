<?php
namespace EvgenyBukharev\Skote\Traits;

use DomainException;
use http\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\Storage;
use Image;

/**
 * Trait ImageThumbnailTrait
 *
 * @package App\Helpers
 */
trait ImageThumbnailTrait
{
    /**
     * @return array
     */
    abstract function getImageThumbnailPermittedDimensions(): array;

    /**
     * @return string
     */
    public function getDefaultThumbnailPath(): string
    {
        return 'default/no_image_1000x700.jpg';
    }

    /**
     * Проверяем существует ли оригинал изображения
     *
     * @param string $type
     * @param string $exists
     *
     * @return bool
     */
    public function existsThumbnailOriginal(string $type, string $exists): bool
    {
        $imagePath = $type . '/' . $exists;
        $image = Storage::disk('public')->path($imagePath);

        return is_file($image);
    }

    /**
     * @param string   $type
     * @param string   $exists
     * @param int|null $width
     * @param int|null $height
     *
     * @return string
     */
    public function getThumbnail(string $type, string $exists, int $width = null, int $height = null): string
    {
        $defaultPath = $this->getDefaultThumbnailPath();
        $imagePath = $type . '/' . $exists;
        $resultPath = !$this->existsThumbnailOriginal($type, $exists) ? $defaultPath : $imagePath;

        if (!is_null($width) || !is_null($height)) {
            $width = $width ?? '';
            $height = $height ?? '';
            $dimensions = $width . 'x' . $height;
            $permittedDimensions = $this->getImageThumbnailPermittedDimensions();

            if (!in_array($dimensions, $permittedDimensions)) {
                throw new DomainException('Не верные указанны размеры изображения. Задайте конфигурацию для ' . $dimensions);
            }
            $thumbPath = 'thumb' . '/' . $dimensions . '/' . $resultPath;

            if (!Storage::disk('public')->exists($thumbPath)) {

                $thumbDir = dirname(Storage::disk('public')->path($thumbPath));
                if (!is_dir($thumbDir)) {
                    mkdir($thumbDir, 0755, true);
                }
                Image::make(Storage::disk('public')->path($resultPath))->fit($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(Storage::disk('public')->path($thumbPath));
            }

            return Storage::url($thumbPath);
        }

        return Storage::url($resultPath);
    }
}
