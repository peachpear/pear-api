<?php
/**
 * Created by PhpStorm.
 * User: iBaiYang
 * Date: 2018/3/28
 * Time: 下午5:05
 */
namespace common\components;

use common\misc\LError;
use yii\base\Exception;

class LException extends Exception
{
    const E_HHVM_FATAL_ERROR = 16777217;

    public function __construct($code = 0)
    {
        $message = LError::getErrMsgByCode($code);
        parent::__construct($message, $code, null);
    }

    /**
     * Returns if error is one of fatal type.
     *
     * @param array $error error got from error_get_last()
     * @return boolean if error is one of fatal type
     */
    public static function isFatalError($error)
    {
        return isset($error['type']) && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR, E_COMPILE_WARNING, self::E_HHVM_FATAL_ERROR]);
    }
}