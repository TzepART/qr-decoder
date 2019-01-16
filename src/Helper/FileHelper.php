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
     * @var string
     */
    private $workBlackAndWhiteDir;

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

        $this->workBlackAndWhiteDir = $this->makeBWDir();
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
     * @param string $file
     * @return string
     */
    public function toBlackAndWhite(string $file)
    {
        $oldFile = $this->workDir.$file;
        $newFile = $this->workBlackAndWhiteDir.'/'.$file;

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

    /**
     * @return string
     */
    protected function makeBWDir(): string
    {
        $workBlackAndWhiteDir = $this->workDir . self::BLACK_AND_WHITE_DIR;
        if (!is_dir($workBlackAndWhiteDir)) {
            mkdir($workBlackAndWhiteDir);
        }

        return $workBlackAndWhiteDir;
    }

}