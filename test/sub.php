<?php


include __DIR__ . '/../vendor/autoload.php';
spl_autoload_register(function($class) {
    $file = __DIR__ . '/../src/yumo/Chat.php';
    if (file_exists($file))  {
        require  $file;
        return  true;
    }
});
use yumo\Chat;

$i = 0;
$chat = Chat::getInstance();

while(1) {
    $i++;
    if ($i > 10) {
        break;
    }
    $msg = $chat->getMsg('pub2sub');
}