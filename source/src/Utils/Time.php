<?php
namespace Utils;

class Time {
    const TIME_MINUTE   = 60;
    const TIME_HOUR     = 3600;
    const TIME_DAY      = 86400;
    const TIME_WEEK     = 604800;
    const TIME_MONTH    = 2592000;
    const TIME_MONTH_31 = 2678400;

    /**
     * @var int|null
     */
    protected static $time = null;

    /**
     * Возвращает время начала дня для переданного времени
     * @param int $time
     * @return int
     */
    public static function getStartTimeDay($time = null) {
        if (is_null($time)) {
            $time = self::getTime();
        }

        return strtotime(date('Y-m-d 00:00:00', $time));
    }

    /**
     * Возвращает начала месяца для переданного времени
     * @param int $time
     * @return int
     */
    public static function getStartTimeMonth($time = null) {
        if (is_null($time)) {
            $time = time();
        }

        return strtotime(date('Y-m-1 00:00:00', $time));
    }

    /**
     * Возвращает кол-во полных дней от переданного времени
     * @param int $fromTime
     * @param int|null $toTime
     * @return int
     */
    public static function getDaysFromTime($fromTime, $toTime = null) {
        if (is_null($toTime)) {
            $toTime = Time::getTime();
        }

        $fromTime = strtotime(date("Y-m-d", $fromTime));
        $toTime = strtotime(date("Y-m-d", $toTime));

        $diff = abs($toTime - $fromTime);
        return (int) floor($diff / self::TIME_DAY);
    }

    /**
     * Устанавливает время
     * @param $time
     */
    public static function setTime($time) {
        static::$time = $time;
    }

    /**
     * Обнуляет время (после вызова метода будет возвращаться реальное время)
     */
    public static function resetTime() {
        static::$time = null;
    }

    /**
     * Возвращает время
     * @return int
     */
    public static function getTime() {
        if (is_null(static::$time)) {
            return time();
        }

        return static::$time;
    }

    /**
     * @return float
     */
    public static function microtime() {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }
}