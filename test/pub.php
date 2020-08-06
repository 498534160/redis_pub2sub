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

try {
    $chat = Chat::getInstance();
    $msg = $_GET['msg'] ?? 'from test';
    $code = $chat->sendMsg('pub2sub', $msg);
    if ($code) {
        var_dump('有人订阅，订阅人数：' . $code);
    } else {
        var_dump('无人订阅');
    }
} catch (Exception $e) {
    var_dump($e->getMessage());
}
