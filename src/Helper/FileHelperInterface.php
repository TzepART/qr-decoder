<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 2019-01-23
 * Time: 17:39
 */

namespace DecoderQR\Helper;


/**
 * Interface FileHelperInterface
 * @package DecoderQR\Helper
 */
interface FileHelperInterface
{
    /**
     * @param bool $optimizeSize
     * @return \Generator
     */
    public function getFileResources($optimizeSize = true) : \Generator;
}