<?php
echo "PHP_VERSION: " . PHP_VERSION . PHP_EOL;
$required_ext = ['mbstring','intl','openssl','pdo','pdo_mysql','xml','dom','simplexml','tokenizer','ctype'];
foreach ($required_ext as $ext) {
    echo $ext . ': ' . (extension_loaded($ext) ? 'OK' : 'MISSING') . PHP_EOL;
}
echo 'Loaded extensions count: ' . count(get_loaded_extensions()) . PHP_EOL;
?>