<?php
declare(strict_types=1);

namespace DecoderQR\Helper;

/**
 * Class ConsoleHelper
 * @package DecoderQR\Helper
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
        $this->options = getopt("", $this->optionFlags);
    }

    /**
     * @return string
     */
    public function getPathOption(): string
    {
        $dataPath = "";

        if (isset($this->options["path"]) && $this->options["path"]) {
            $dataPath = $this->options["path"];
        }

        return $dataPath;
    }

    /**
     * @return bool
     */
    public function getCompressOption(): bool
    {
        $compress = false;

        if (isset($this->options["compress"]) && $this->options["compress"] === "yes") {
            $compress = true;
        }

        return $compress;
    }


}
