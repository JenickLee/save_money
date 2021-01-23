<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/23
 * Time: 2:11 下午
 */

namespace app\common\lib;


class Date
{
    /**
     * Notes:获取指定日期所在月的开始日期与结束日期
     * User: Jenick
     * Date: 2021/1/23
     * Time: 2:12 下午
     * @param $date
     * @param bool $returnFirstDay 为true返回开始日期，否则返回结束日期
     * @return false|string
     */
    public static function getMonthRange($date, $returnFirstDay = true)
    {
        $timestamp = strtotime($date);
        if ($returnFirstDay) {
            $firstDay = date('Y-m-01 00:00:00', $timestamp);
            return $firstDay;
        }
        $lastDay = date('Y-m-t 23:59:59', $timestamp);
        return $lastDay;
    }

    /**
     * Notes:查询指定时间范围内的所有日期，月份，季度，年份
     * User: Jenick
     * Date: 2021/1/23
     * Time: 2:19 下午
     * @param $startDate //指定开始时间，Y-m-d格式
     * @param $endDate //指定结束时间，Y-m-d格式
     * @param $type //类型，day 天，month 月份，quarter 季度，year 年份
     * @return array|string
     */
    public static function getDateByInterval($startDate, $endDate, $type = 'day')
    {
        if (date('Y-m-d', strtotime($startDate)) != $startDate || date('Y-m-d', strtotime($endDate)) != $endDate) {
            return '日期格式不正确';
        }

        $tempDate = $startDate;
        $returnData = [];
        $i = 0;
        if ($type == 'day') {    // 查询所有日期
            while (strtotime($tempDate) < strtotime($endDate)) {
                $tempDate = date('Y-m-d', strtotime('+' . $i . ' day', strtotime($startDate)));
                $returnData[] = $tempDate;
                $i++;
            }
        } elseif ($type == 'month') {    // 查询所有月份以及开始结束时间
            while (strtotime($tempDate) < strtotime($endDate)) {
                $temp = [];
                $month = strtotime('first day of +' . $i . ' month', strtotime($startDate));
                $temp['name'] = date('Y-m', $month);
                $temp['startDate'] = date('Y-m-01', $month);
                $temp['endDate'] = date('Y-m-t', $month);
                $tempDate = $temp['endDate'];
                $returnData[] = $temp;
                $i++;
            }
        } elseif ($type == 'quarter') {    // 查询所有季度以及开始结束时间
            while (strtotime($tempDate) < strtotime($endDate)) {
                $temp = [];
                $quarter = strtotime('first day of +' . $i . ' month', strtotime($startDate));
                $q = ceil(date('n', $quarter) / 3);
                $temp['name'] = date('Y', $quarter) . '第' . $q . '季度';
                $temp['startDate'] = date('Y-m-01', mktime(0, 0, 0, $q * 3 - 3 + 1, 1, date('Y', $quarter)));
                $temp['endDate'] = date('Y-m-t', mktime(23, 59, 59, $q * 3, 1, date('Y', $quarter)));
                $tempDate = $temp['endDate'];
                $returnData[] = $temp;
                $i = $i + 3;
            }
        } elseif ($type == 'year') {    // 查询所有年份以及开始结束时间
            while (strtotime($tempDate) < strtotime($endDate)) {
                $temp = [];
                $year = strtotime('+' . $i . ' year', strtotime($startDate));
                $temp['name'] = date('Y', $year) . '年';
                $temp['startDate'] = date('Y-01-01', $year);
                $temp['endDate'] = date('Y-12-31', $year);
                $tempDate = $temp['endDate'];
                $returnData[] = $temp;
                $i++;
            }
        }
        return $returnData;
    }
}