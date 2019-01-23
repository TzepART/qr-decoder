<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 16/01/2019
 * Time: 18:58
 */

namespace DecoderQR\Helper;

use DecoderQR\Helper\TypeFile\TypeFileInterface;

/**
 * Class ConsoleFileHelper
 * @package DecoderQR\Helper
 */
class ConsoleFileHelper implements FileHelperInterface
{

    use TypeFileTrait;

    /**
     * @var array
     */
    private $files;

    /**
     * @var string
     */
    private $workPath;


    /**
     * DecoderQR constructor.
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
    public function getFileResources($optimizeSize = true) : \Generator
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


}