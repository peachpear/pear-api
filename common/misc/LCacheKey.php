<?php
namespace common\misc;

/**
 * Class LCacheKey
 * @package common\misc
 */
class LCacheKey
{
    /**
     * redis常量
     */
    const REDIS_PARAM = array(
        'class_boss' => 'class:boss:',  // 会议部分锁boss的常量
        'class_staff' => 'class:staff:',  // 会议部分锁staff的常量
    );

    /**
     * redis锁定时间
     */
    const REDIS_LOCK_TIME = array(
        'class_boss' => 60,  // 会议部分锁boss的锁定时间
        'class_staff' => 60,  // 会议部分锁staff的锁定时间
    );

    /**
     * @param string $type
     * @return int|mixed
     * 获取对应的锁定时间--默认锁定60s
     */
    public static function getRedisLockTime($type = 'class_boss')
    {
        if (isset(self::REDIS_LOCK_TIME[$type])) {
            return self::REDIS_LOCK_TIME[$type];
        }

        return 60;
    }

    /**
     * @param string $type
     * @return bool|mixed
     * 获取rediskey
     */
    public static function getRedisKey($type = 'class_boss')
    {
        if ( isset(self::REDIS_PARAM[$type]) ) {
            return self::REDIS_PARAM[$type];
        }

        return false;
    }
}