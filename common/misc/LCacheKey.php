<?php
namespace common\misc;

/**
 * Created by PhpStorm.
 * User: iBaiYang
 * Date: 2018/4/8
 * Time: 下午10:11
 */
class LCacheKey
{
    /**
     * redis常量
     */
    const REDIS_PARAM = array(
        'class_teacher' => 'class:teacher:',//排课部分锁老师的常量
        'class_student' => 'class:student:',//排课部分锁学生的常量
    );

    /**
     * redis锁定时间
     */
    const REDIS_LOCK_TIME = array(
        'class_teacher' => 60,//排课部分锁老师的锁定时间
        'class_student' => 60,///排课部分锁学生的锁定时间
    );

    /**
     * @param string $type
     * @return int|mixed
     * @created by wt
     * 获取对应的锁定时间--默认锁定60s
     */
    public static function getRedisLockTime($type = 'class_teacher')
    {
        if (isset(self::REDIS_LOCK_TIME[$type])) {
            return self::REDIS_LOCK_TIME[$type];
        }

        return 60;
    }

    /**
     * @param string $type
     * @return bool|mixed
     * @created by wt
     * 获取rediskey
     */
    public static function getRedisKey($type = 'class_teacher')
    {
        if ( isset(self::REDIS_PARAM[$type]) ) {
            return self::REDIS_PARAM[$type];
        }

        return false;
    }
}