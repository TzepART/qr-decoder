<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 2019-01-23
 * Time: 17:42
 */

namespace DecoderQR\Helper;


use DecoderQR\Helper\TypeFile\TypeFileInterface;

/**
 * Class FileHelper
 * @package DecoderQR\Helper
 */
class FileHelper implements FileHelperInterface
{
    use TypeFileTrait;

    /**
     * @var string
     */
    private $filePath;

    /**
     * FileHelper constructor.
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }


    /**
     * @param bool $optimizeSize
     * @return \Generator
     * @throws \Exception
     */
    public function getFileResources($optimizeSize = true) : \Generator
    {
        //create resource
        /** @var TypeFileInterface $fileHelper */
        list($resource,$fileHelper) = $this->initTypeFile($this->filePath);

        if($optimizeSize){
            $resource = $fileHelper->optimizeSize($resource);
        }

        yield $resource;
    }
}