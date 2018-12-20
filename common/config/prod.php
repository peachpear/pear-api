<?php
defined("ENV") || define("ENV", "prod");
$baseConfig = include('base.php');

$commonConfig = array(
    'components' => array(
        'cache' => array(
            'host' => '',
            'port' => 6379,
            "password" => "",
            'keyPrefix' => '',
        ),
        'db'  => array(
            'dsn' => '',
            'username' => '',
            'password' => '',
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
                'port' => '',
                'login' => '',
                'password' => ''
            )
        ),
    ),
    'params' => array(
    ),
    "configCenter" => [
        "filePath" => "/config/prod/",
        "fileExt" => "json",
    ]

);

return [$baseConfig, $commonConfig];