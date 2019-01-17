<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 17/01/2019
 * Time: 16:36
 */

namespace App\Helper;


class JpegFile implements TypeFileInterface
{
    public function toBlackAndWhite(string $oldPath, string $newPath) : void
    {
        $img = imagecreatefromjpeg($oldPath);

        $x = imagesx($img);
        $y = imagesy($img);

        list($new_width, $new_height) = $this->getScalingSize($x,$y);

        $s = imagecreatetruecolor($new_width, $new_height);

        imagecopyresampled($s, $img, 0, 0, 0, 0, $new_width, $new_height,
            $x, $y);

        imagefilter($s, IMG_FILTER_GRAYSCALE);
        imagejpeg($s, $newPath);
        imagedestroy($s);
        imagedestroy($img);
    }

}