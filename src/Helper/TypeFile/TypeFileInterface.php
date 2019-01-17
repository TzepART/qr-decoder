<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 17/01/2019
 * Time: 16:35
 */

namespace App\Helper;


/**
 * Interface TypeFileInterface
 * @package App\Helper
 */
interface TypeFileInterface
{
    /**
     * @param string $oldPath
     * @param string $newPath
     */
    public function toBlackAndWhite(string $oldPath, string $newPath) : void;
}