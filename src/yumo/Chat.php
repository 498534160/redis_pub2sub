<?php


namespace yumo;


use Predis\Client;

class Chat
{
    protected  $predis;
    protected static $instance;
    protected function __construct()
    {
        $config = [
            'host' => '127.0.0.1',
            'port' => '6379',
            'read_write_timeout' => 0,
        ];
        $this->predis = new Client($config);
        $this->predis->auth('L8Aai3HPrJkwRMLP');
    }
    public static  function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }
    public function sendMsg(string $chat, string $msg): int
    {
        return $this->predis->publish($chat, $msg);
    }

    public  function getMsg(string $chat)
    {
        $pubsub = $this->predis->pubSubLoop();
        $pubsub->subscribe($chat);
        static $i = 0;
        foreach ($pubsub as $message) {
            switch ($message->kind) {
                case 'subscribe':
                    $msg =  "订阅频道为 {$message->channel}";
                    break;
                case 'message':
                    if ($message->channel == 'control_channel') {
                        if ($message->payload == 'quit_loop') {
                            $msg =  'Aborting pubsub loop...';
                            $pubsub->unsubscribe();
                        } else {
                            $msg =  "无法识别的消息: {$message->payload}";
                        }
                    } else {
                        $msg =  "收到的消息 {$message->channel}: {$message->payload}";
                    }
                    break;
            }
            file_put_contents('1.txt', $msg . PHP_EOL, FILE_APPEND);
        }

    }
}