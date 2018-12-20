<?php

namespace common\service;

use Yii;

/**
 * Created by PhpStorm.
 * User: iBaiYang
 * Date: 2018/3/31
 * Time: 上午10:29
 */
class LLogRequestBlackListService
{

    /**
     *是否在请求记录的黑名单中
     * @param $url
     * @return bool
     */
    public static function inBlackList($url)
    {
        if (isset(Yii::$app->params['logBlackList'])) {
            $blackList = Yii::$app->params['logBlackList'];
            return in_array($url, $blackList) ? true : false;
        }
        return false;
    }
}
