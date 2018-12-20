<?php
namespace common\components;

use Yii;
use yii\console\Application;
use yii\helpers\ArrayHelper;
use peachpear\pearLeaf\ConfigService;

/**
 * Created by PhpStorm.
 * User: iBaiYang
 * Date: 2018/4/13
 * Time: 下午3:17
 */
class LConsoleApplication extends Application
{
    public function __construct(array $config = [])
    {
        ini_set("display_errors", true);
        $this->initAliases($config);
        // 加载配置中心文件，替换config
        if (!empty($config["configCenter"]))
        {
            $filePath = $config["ConfigService"]["filePath"];
            $fileExtension = $config["ConfigService"]["fileExt"];
            $configService = ConfigService::getInstance($filePath, $fileExtension);
            $configService->loadJson($config);
            $config = ArrayHelper::merge($config, $configService->getConfig());
            unset($config["configCenter"]);
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
        $this->enableCoreCommands = false;
    }
}