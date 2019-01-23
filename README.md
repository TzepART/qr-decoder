# QR decoder

This is QR decoder on base [this QR-decoder](https://github.com/khanamiryan/php-qrcode-detector-decoder) 
with function of precompression.


Example console command for precompression for directory:

  `./bin/console.php --path data/good_data/ --compress="yes"`


Example console command for precompression for separate file:

  `./bin/console.php --path data/good_data/check_1.jpg --compress="yes"`
  
  
Example Using without console command

```php
<?php

use \DecoderQR\Helper\FileHelper;
use DecoderQR\DecoderQR;

$dataPath = '/path/to/decoder/file.png';
$compressFlag = true;

$fileHelper = new FileHelper($dataPath);
$results = (new DecoderQR($fileHelper))->getResults($compressFlag);
var_dump($results); //output decoding results
```
