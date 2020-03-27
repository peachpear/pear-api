<?php
namespace common\components;

use peachpear\pearLeaf\ConfigService;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Application;

/**
 * Web应用
 * Class LApplication
 * @package common\components
 */
class LApplication extends Application
{
    /**
     * 应用构建
     * 配置从服务器重载
     * LApplication constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->initAliases($config);

        // 加载配置中心文件，完善config
        if (!empty($config["configService"])) {
            $filePath = $config["configService"]["filePath"];
            $fileExtension = $config["configService"]["fileExt"];
            $configService = ConfigService::getInstance($filePath, $fileExtension);
            $configService->loadJson($config);
            $config = ArrayHelper::merge($config, $configService->getConfig());
            unset($config["configService"]);
        }

        parent::__construct($config);
    }

    /**
     * 初始化配置别名
     * @param $config
     */
    public function initAliases(&$config)
    {
        if (isset($config['aliases'])) {
            foreach ($config['aliases'] as $key=>$value)
            {
                Yii::setAlias($key, $value);
            }
            unset($config['aliases']);
        }
    }

    /**
     * 重新定义核心类
     * 摒弃无用核心类
     * 覆盖父类定义 yii\web\Application->coreComponents()
     * @return array
     */
    public function coreComponents()
    {
        return [
            'log' => ['class' => 'yii\log\Dispatcher'],
            'response' => ['class' => 'yii\web\Response'],
            'urlManager' => ['class' => 'yii\web\UrlManager'],
        ];
    }
}