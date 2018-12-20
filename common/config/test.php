<?php
defined("ENV") || define("ENV", "test");
$baseConfig = include('base.php');

$commonConfig = array(
    'components' => array(
        'cache' => array(
            'host' => '',
            'port' => 6379,
            'keyPrefix' => '',
        ),
        'db'  => array(
            'dsn' => '',
            'username'         => '',
            'password'         => '',
        ),
        'kafkaProducer' => array(
            "metadata" => array(
                "brokerList" => "",
            ),
            "requireAck" => 0,
        ),
        'queue' => array(
            'credentials' => array(
                'host' => '',
                'port' => '5672',
                'login' => '',
                'password' => ''
            )
        ),
    ),
    'params' => array(
    ),
    "configCenter" => [
        "filePath" => "/config/test/",
        "fileExt" => "json",
    ]

);

return [$baseConfig, $commonConfig];
