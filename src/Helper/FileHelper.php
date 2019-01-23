<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 16/01/2019
 * Time: 18:58
 */

namespace DecoderQR\Helper;

use DecoderQR\Helper\TypeFile\JpegFile;
use DecoderQR\Helper\TypeFile\PngFile;
use DecoderQR\Helper\TypeFile\TypeFileInterface;

/**
 * Class FileHelper
 * @package DecoderQR\Helper
 */
class FileHelper
{
    /**
     * @var array
     */
    private $files;

    /**
     * @var string
     */
    private $workPath;


    /**
     * AppQrReader constructor.
     * @param string $workPath
     */
    public function __construct(string $workPath)
    {
        $this->workPath = $workPath;

        if(is_dir($this->workPath)){

            $tmpFiles = array_values(array_filter(scandir($this->workPath),function ($elementName){
                return preg_match("/\.jpg|\.jpeg|\.png/",strtolower($elementName));
            }));
            array_walk($tmpFiles, function (&$value) {
                $value = $this->workPath.$value;
            });
            $this->files = $tmpFiles;

        }elseif (is_file($this->workPath)){
            $this->files[] = $this->workPath;
        }

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
    public function getWorkPath(): string
    {
        return $this->workPath;
    }

    /**
     * @param bool $optimizeSize
     * @return \Generator
     * @throws \Exception
     */
    public function getFileResources($optimizeSize = true)
    {
        foreach ($this->getFiles() as $filePath) {
            //create resource
            /** @var TypeFileInterface $fileHelper */
            list($resource,$fileHelper) = $this->initTypeFile($filePath);
            if($optimizeSize){
                $resource = $fileHelper->optimizeSize($resource);
            }
            yield $resource;
        }
    }

    /**
     * @param $path
     * @return array
     * @throws \Exception
     */
    protected function initTypeFile(string $path) : array
    {
        //TODO make validation
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if($ext == "png"){
            $resource = imagecreatefrompng($path);
            $fileHelper = new PngFile();
        }elseif (preg_match("/jpg|jpeg/",$ext)){
            $resource = imagecreatefromjpeg($path);
            $fileHelper = new JpegFile();
        }else{
            throw new \Exception("Unknown file type");
        }

        return [$resource,$fileHelper];
    }
}