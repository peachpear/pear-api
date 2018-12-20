<?php
return array(
	'name' => 'APP',
	'id'   =>   "php-demo",
	'basePath' => dirname(__DIR__),
	'defaultRoute' => 'class/index',
    'controllerNamespace'   =>  "backend\controllers",
    'aliases' => [
        '@backend' => realpath(__DIR__."/../"),
    ],
    "components" => [
        // 内部组件
        'request' => array(
            'class' => 'common\components\LHttpRequest',
            'enableCookieValidation' => true,
            'enableCsrfValidation' => false,
            'parsers'    =>  [
                'application/json' => 'yii\web\JsonParser',
            ],
        ),
        'response'  =>  array(
            'format'=> "json",
        ),
        'errorHandler'  =>  array(
            'class' => 'common\components\LErrorHandler',
        ),
        'urlManager'   =>  array(
            'enablePrettyUrl'   =>  true,
        ),
    ]
);