<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 17/01/2019
 * Time: 17:45
 */

namespace App\Helper\TypeFile;


abstract class TypeFileAbstract implements TypeFileInterface
{
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