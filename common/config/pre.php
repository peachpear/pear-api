<?php
defined("ENV") || define("ENV", "pre");
$baseConfig = include('base.php');

$commonConfig = array(
    'components' => array(
        'cache' => array(
            'host' => '',
            'port' => 6379,
            'database' => 0,
            'keyPrefix' => '',
        ),
        'db'  => array(
            'dsn' => '',
            'username' => '',
            'password' => '',
        ),
        'kafkaProducer' => array(
            "metadata" => array(
                "brokerList" => "192.168.40.122:9200",
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
        "filePath" => "/config/pre/",
        "fileExt" => "json",
    ]

);

return [$baseConfig, $commonConfig];
