<?php
declare(strict_types=1);

namespace DecoderQR\Helper;

use DecoderQR\Helper\TypeFile\JpegFile;
use DecoderQR\Helper\TypeFile\PngFile;

/**
 * Trait TypeFileTrait
 * @package DecoderQR\Helper
 */
trait TypeFileTrait
{
    /**
     * @param $path
     * @return array
     * @throws \Exception
     */
    protected function initTypeFile(string $path): array
    {
        //TODO make validation
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if ($ext == "png") {
            $resource = imagecreatefrompng($path);
            $fileHelper = new PngFile();
        } elseif (preg_match("/jpg|jpeg/", $ext)) {
            $resource = imagecreatefromjpeg($path);
            $fileHelper = new JpegFile();
        } else {
            throw new \Exception("Unknown file type");
        }

        return [$resource, $fileHelper];
    }
}
