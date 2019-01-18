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
        "dir:", // Requires values
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
    }

    /**
     * @return string
     */
    public function getDirOption() : string
    {
        $dataDir = "";

        if($this->options["dir"] && is_dir($this->options["dir"])){
            $dataDir = $this->options["dir"];
        }

        return $dataDir;
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