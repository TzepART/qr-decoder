<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 16/01/2019
 * Time: 18:58
 */

namespace App\Helper;

/**
 * Class FileHelper
 * @package App\Helper
 */
class FileHelper
{
    /**
     * @var array
     */
    private $files;

    /**
     * @var string
     */
    private $workDir;

    /**
     * AppQrReader constructor.
     * @param string $workDir
     */
    public function __construct(string $workDir)
    {
        $this->workDir = $workDir;
        $this->files = array_values(array_filter(scandir($workDir),function ($elementName){
            return preg_match("/\.jpg|\.jpeg/",strtolower($elementName));
        }));
    }

    /**
     * @return array
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * @return string
     */
    public function getWorkDir(): string
    {
        return $this->workDir;
    }

    /**
     * @param resource $oldResource
     * @return resource
     */
    public function optimizeSize($oldResource)
    {
        $x = imagesx($oldResource);
        $y = imagesy($oldResource);

        list($new_width, $new_height) = $this->getScalingSize($x,$y);

        $newResource = imagecreatetruecolor($new_width, $new_height);

        imagecopyresampled($newResource, $oldResource, 0, 0, 0, 0, $new_width, $new_height,
            $x, $y);

        imagedestroy($oldResource);

        return $newResource;

    }

    /**
     * @param resource $resource
     * @return resource
     */
    public function toBlackAndWhite($resource)
    {
        imagefilter($resource, IMG_FILTER_GRAYSCALE);
        return $resource;
    }

    /**
     * @param int $old_x
     * @param int $old_y
     * @param int $new_width
     * @param int $new_height
     * @return array
     */
    protected function getScalingSize(int $old_x, int $old_y, int $new_width = 800, int $new_height = 800)
    {
        $thumb_w = 0;
        $thumb_h = 0;

        if ($old_x > $old_y) {
            $thumb_w = $new_width;
            $thumb_h = $old_y * ($new_height / $old_x);
        }

        if ($old_x < $old_y) {
            $thumb_w = $old_x * ($new_width / $old_y);
            $thumb_h = $new_height;
        }

        if ($old_x == $old_y) {
            $thumb_w = $new_width;
            $thumb_h = $new_height;
        }

        return [$thumb_w, $thumb_h];
    }

}