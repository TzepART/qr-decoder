<?php
declare(strict_types=1);

namespace DecoderQR\Helper\TypeFile;

/**
 * Interface TypeFileInterface
 * @package DecoderQR\Helper
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
