<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 16/01/2019
 * Time: 13:29
 */

namespace App;

use Zxing\QrReader;

class AppQrReader
{
    const BLACK_AND_WHITE_DIR = "black_and_white";

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

    public function getResult($blackWhite = true)
    {
        $results = [];
        foreach ($this->files as $file) {
            $path = $this->workDir.$file;
            try {
                if($blackWhite){
                    $path = $this->toBlackAndWhite($file);
                }
                $qrcode = new QrReader($path);
                $results[$path] = $qrcode->text(); //return decoded text from QR Code
            } catch (\Exception $exception) {
                $results[$path] = $exception->getMessage();
            }
            echo memory_get_usage() . PHP_EOL;
        }

        return $results;
    }

    public function toBlackAndWhite(string $file)
    {
        $workBlackAndWhiteDir = $this->workDir.self::BLACK_AND_WHITE_DIR;
        if(!is_dir($workBlackAndWhiteDir)){
            mkdir($workBlackAndWhiteDir);
        }

        $oldFile = $this->workDir.$file;
        $newFile = $workBlackAndWhiteDir.'/'.$file;

        $img = imagecreatefromjpeg($oldFile);

        $x = imagesx($img);
        $y = imagesy($img);

        list($new_width, $new_height) = $this->getScalingSize($x,$y);

        $s = imagecreatetruecolor($new_width, $new_height);

        imagecopyresampled($s, $img, 0, 0, 0, 0, $new_width, $new_height,
            $x, $y);

        imagefilter($s, IMG_FILTER_GRAYSCALE);
        imagejpeg($s, $newFile);
        imagedestroy($s);
        imagedestroy($img);

        return $newFile;

    }

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