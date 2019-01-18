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
     * @var string
     */
    protected $shortopts = "d:";  // Requires values

    /**
     * @var array
     */
    protected $longopts  = [
        "required:",     // Requires values
    ];

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @return string
     */
    public function getDirOption() : string
    {
        $dataDir = "";
        $options = getopt($this->shortopts, $this->longopts);

        if($options["d"] && is_dir($options["d"])){
            $dataDir = $options["d"];
        }

        return $dataDir;
    }


}