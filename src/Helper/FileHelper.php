<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 16/01/2019
 * Time: 18:58
 */

namespace App\Helper;

use App\Helper\TypeFile\JpegFile;
use App\Helper\TypeFile\PngFile;
use App\Helper\TypeFile\TypeFileInterface;

/**
 * Class FileHelper
 * @package App\Helper
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
    private $workDir;


    /**
     * AppQrReader constructor.
     * @param string $workDir
     */
    public function __construct(string $workDir)
    {
        $this->workDir = $workDir;
        $this->files = array_values(array_filter(scandir($workDir),function ($elementName){
            return preg_match("/\.jpg|\.jpeg|\.png/",strtolower($elementName));
        }));
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
     * @param bool $optimizeSize
     * @return \Generator
     * @throws \Exception
     */
    public function getFileResources($optimizeSize = true)
    {
        foreach ($this->getFiles() as $file) {
            $path = $this->getWorkDir().$file;
            //create resource
            /** @var TypeFileInterface $fileHelper */
            list($resource,$fileHelper) = $this->initTypeFile($path);
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