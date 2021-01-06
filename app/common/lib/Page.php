<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * DateTime: 2020/4/15 15:41
 */

namespace app\common\lib;


class Page
{
    /**
     * Notes:从请求参数中获取page和pageSize的值（列表才有）
     * User: Jenick
     * Date: 2020/01/05
     * Time: 15:00
     * @param int $page
     * @param int $pageSize
     * @param int $maxPageSize
     * @param int $defaultPageSize
     * @return array|int
     */
    public static function getPage(int $page = 0, int $pageSize = 15, int $maxPageSize = 99, int $defaultPageSize = 15)
    {
        $page = [
            'page' => $page,
            'pageSize' => $pageSize,
        ];
        if(intval($page['pageSize']) > $maxPageSize) {
            $page['pageSize'] = $defaultPageSize;
        }
        return $page;
    }
}