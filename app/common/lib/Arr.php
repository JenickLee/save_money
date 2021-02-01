<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/2/1
 * Time: 12:38 下午
 */

namespace app\common\lib;


class Arr
{

    /**
     * Notes:返回数组中指定多列
     * User: Jenick
     * Date: 2021/2/1
     * Time: 12:38 下午
     * @param array $input 需要取出数组列的多维数组
     * @param String $column_keys 要取出的列名，逗号分隔，如不传则返回所有列
     * @param String $index_key 作为返回数组的索引的列
     * @return array
     */
    public static function array_columns($input, $column_keys = null, $index_key = null)
    {
        $result = array();
        $keys = isset($column_keys) ? explode(',', $column_keys) : array();
        if ($input) {
            foreach ($input as $k => $v) {
                // 指定返回列
                if ($keys) {
                    $tmp = array();
                    foreach ($keys as $key) {
                        $tmp[$key] = $v[$key];
                    }
                } else {
                    $tmp = $v;
                }
                // 指定索引列
                if (isset($index_key)) {
                    $result[$v[$index_key]] = $tmp;
                } else {
                    $result[] = $tmp;
                }

            }
        }
        return $result;
    }

}