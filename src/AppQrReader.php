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
     * @param bool $blackWhite
     * @return array
     */
    public function getResult($blackWhite = true)
    {
        $results = [];
        foreach ($this->fileHelper->getFiles() as $file) {
            $path = $this->fileHelper->getWorkDir().$file;
            try {
                if($blackWhite){
                    $path = $this->fileHelper->toBlackAndWhite($file);
                }
                $qrcode = new QrReader($path);
                $results[$path] = $qrcode->text(); //return decoded text from QR Code
            } catch (\Exception $exception) {
                $results[$path] = $exception->getMessage();
            }
//            echo memory_get_usage() . PHP_EOL;
        }

        return $results;
    }
}