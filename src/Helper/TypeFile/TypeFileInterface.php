<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 17/01/2019
 * Time: 16:35
 */

namespace App\Helper\TypeFile;


/**
 * Interface TypeFileInterface
 * @package App\Helper
 */
interface TypeFileInterface
{
    /**
     * @param resource $oldResource
     * @return resource
     */
    public function optimizeSize($oldResource);

    /**
     * @param resource $resource
     * @return resource
     */
    public function toBlackAndWhite($resource);
}