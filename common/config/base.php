<?php
defined("APP_NAME") || define("APP_NAME", "demo");
return array(
    'aliases' => [
        '@common' => realpath(__DIR__."/../"),
    ],
    'bootstrap' => ['log'],
	'components' => array(
		'cache' => array(
			'class' => 'common\components\LRedisCache',
			'hashKey' => false,
		),
		// db
        'db' => array(
            'class' => '\yii\db\Connection',
            'charset' => 'utf8mb4',
            'enableQueryCache'  =>  false,
        ),
		'curl'	=>	array(
			'class' => 'common\components\LComponentCurl',
		),
        'kafkaProducer' =>  array(
            "class" =>  'common\components\LKafkaProducerQueue'
        ),
        'queue' =>  array(
            "class" =>  'common\components\LRabbitQueue'
        ),
        'log' => array(
            'targets' => [
                'kafka' =>
                    [
                        'class' => 'common\lib\LKafkaTarget',
                    ],
            ],
        )
	)
);
