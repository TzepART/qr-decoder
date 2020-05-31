<?php
declare(strict_types=1);

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
