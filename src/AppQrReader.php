<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 16/01/2019
 * Time: 13:29
 */

namespace App;

use App\Helper\FileHelper;
use Zxing\QrReader;


/**
 * Class AppQrReader
 * @package App
 */
class AppQrReader
{
    /**
     * @var FileHelper
     */
    private $fileHelper;

    /**
     * AppQrReader constructor.
     * @param FileHelper $fileHelper
     */
    public function __construct(FileHelper $fileHelper)
    {
        $this->fileHelper = $fileHelper;
    }

    /**
     * @param bool $optimizeSize
     * @return array
     */
    public function getResult($optimizeSize = true)
    {
        $results = [];
        foreach ($this->fileHelper->getFiles() as $file) {
            $path = $this->fileHelper->getWorkDir().$file;
            //create resource
            $img = $this->getFileResource($path);

            try {
                if($optimizeSize){
                    $img = $this->fileHelper->optimizeSize($img);
                }
                $qrcode = new QrReader($img, QrReader::SOURCE_TYPE_RESOURCE, false);
                $results[$path] = $qrcode->text(); //return decoded text from QR Code
            } catch (\Exception $exception) {
                $results[$path] = $exception->getMessage();
                imagedestroy($img);
            }

            echo memory_get_usage() . PHP_EOL;
        }

        return $results;
    }

    /**
     * @param $path
     * @return resource
     */
    protected function getFileResource(string $path)
    {
        //TODO make validation and choose type
        $img = imagecreatefromjpeg($path);
        return $img;
    }
}