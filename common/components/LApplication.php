<?php
namespace common\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Application;
use peachpear\pearLeaf\ConfigService;

/**
 * Class LApplication
 * @package common\components
 * User: iBaiYang
 */
class LApplication extends Application
{
    public function __construct(array $config = [])
    {
        $this->initAliases($config);
        // 加载配置中心文件，替换config
        if (!empty($config["ConfigService"])) {
            $filePath = $config["ConfigService"]["filePath"];
            $fileExtension = $config["ConfigService"]["fileExt"];
            $configService = ConfigService::getInstance($filePath, $fileExtension);
            $configService->loadJson($config);
            $config = ArrayHelper::merge($config, $configService->getConfig());
            unset($config["ConfigService"]);
        }

        parent::__construct($config);
    }

    public function initAliases(&$config)
    {
        if (isset($config['aliases'])) {
            foreach ($config['aliases'] as $key=>$value) {
                Yii::setAlias($key, $value);
            }
            unset($config['aliases']);
        }
    }

    public function coreComponents()
    {
        return [
            'log' => ['class' => 'yii\log\Dispatcher'],
            'response' => [
                'class' => 'yii\web\Response',
            ],
            'urlManager' => [
                'class' => 'yii\web\UrlManager',
            ],
        ];
    }
}