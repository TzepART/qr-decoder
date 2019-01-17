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
    public function getResults($optimizeSize = true)
    {
        $results = [];

        try {
            foreach ($this->fileHelper->getFileResources($optimizeSize) as $fileResource) {
                $qrcode = new QrReader($fileResource, QrReader::SOURCE_TYPE_RESOURCE, false);
                $results[] = $qrcode->text(); //return decoded text from QR Code
                imagedestroy($fileResource);
//                echo memory_get_usage() . PHP_EOL;
            }
        } catch (\Exception $exception) {
            $results[] = $exception->getMessage();
        }

        return $results;
    }
}