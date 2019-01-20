<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 18/01/2019
 * Time: 16:21
 */

namespace App\Helper;


/**
 * Class ConsoleHelper
 * @package App\Helper
 */
class ConsoleHelper
{
    /**
     * @var array
     */
    protected $optionFlags = [
        "path:", // Requires values
        "compress::", // No requires values
    ];

    /**
     * @var array
     */
    protected $options = [];

    /**
     * ConsoleHelper constructor.
     */
    public function __construct()
    {
        $this->options = getopt("",$this->optionFlags);
        var_dump($this->options);
        die();
    }

    /**
     * @return string
     */
    public function getPathOption() : string
    {
        $dataPath = "";

        if(isset($this->options["path"]) && $this->options["path"]){
            $dataPath = $this->options["path"];
        }

        return $dataPath;
    }

    /**
     * @return bool
     */
    public function getCompressOption() : bool
    {
        $compress = false;

        if(isset($this->options["compress"]) && $this->options["compress"] === "yes"){
            $compress = true;
        }

        return $compress;
    }


}