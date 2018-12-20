<?php
/**
 * Created by PhpStorm.
 * User: iBaiYang
 */

namespace common\misc;

class LError
{

    const SUCCESS = 200;
    const INTERNAL_ERROR = 500;

    public static $errMsg = array(
        self::SUCCESS => '成功',
    );


    public static function getErrMsg($message, array $params = array())
    {
        $patterns = array_map(function($pattern) {
            return "/#$pattern#/";
        }, array_keys($params));
        $values = array_values($params);
        return preg_replace($patterns, $values, $message);
    }

    public static function getErrMsgByCode($code, array $params = array())
    {
        $errMsg = static::errorMsg();
        $message = isset($errMsg[$code]) ? $errMsg[$code] : '服务器忙，请稍后再试～';
        return self::getErrMsg($message, $params);
    }

    public static function errorMsg()
    {
        return self::$errMsg;
    }

    /**
     * 合并错误码数组，保证第一个数组会被后面的数组覆盖
     * @param array $errMsg
     * @param array $extendMsg
     * @return array
     */
    public static function mergeErrorMsg($errMsg, $extendMsg)
    {
        $args = func_get_args();
        $res = array_shift($args);
        while (!empty($args)) {
            $next = array_shift($args);
            foreach ($next as $k => $v) {
                if (is_array($v) && isset($res[$k]) && is_array($res[$k]))
                    $res[$k] = self::mergeErrorMsg($res[$k], $v);
                else
                    $res[$k] = $v;
            }
        }
        return $res;
    }

}
