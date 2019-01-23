<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 16/01/2019
 * Time: 13:29
 */

namespace DecoderQR;

use DecoderQR\Helper\FileHelperInterface;
use Zxing\QrReader;


/**
 * Class AppQrReader
 * @package DecoderQR
 */
class AppQrReader
{
    /**
     * @var FileHelperInterface
     */
    private $fileHelper;

    /**
     * AppQrReader constructor.
     * @param FileHelperInterface $fileHelper
     */
    public function __construct(FileHelperInterface $fileHelper)
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