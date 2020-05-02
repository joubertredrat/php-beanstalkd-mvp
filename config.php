<?php
require(__DIR__.'/vendor/autoload.php');

$beanstalkdParams    = array(
    'host'  => '127.0.0.1',
    'port'  => 11300
);

$pdoParams    = array(
    'dsn'       => 'mysql:host=127.0.0.1;dbname=joubert_queue;charset=utf8',
    'username'  => 'root',
    'password'  => 'verdade',
    'table_name'=> 'queue'
);