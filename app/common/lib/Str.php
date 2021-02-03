<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * Date: 2021/1/17
 * Time: 10:51 下午
 */

namespace app\common\lib;


class Str
{
    //获取汉字的首字母
    public static function getFirstCharters($str)
    {
        try {
            if (empty($str)) {
                return '';
            }

            //取出参数字符串中的首个字符
            $temp_str = substr($str, 0, 1);
            if (ord($temp_str) > 127) {
                $str = substr($str, 0, 3);
            } else {
                $str = $temp_str;
                $fchar = ord($str[0]);
                if ($fchar >= ord('A') && $fchar <= ord('z')) {
                    return strtoupper($temp_str);
                } else {
                    return null;
                }
            }

            $s1 = iconv('UTF-8', 'gb2312//IGNORE', $str);
            if (empty($s1)) {
                return null;
            }
            $s2 = iconv('gb2312', 'UTF-8', $s1);
            if (empty($s2)) {
                return null;
            }


            $s = $s2 == $str ? $s1 : $str;
            $asc = ord($s[0]) * 256 + ord($s[1]) - 65536;
            if ($asc >= -20319 && $asc <= -20284)
                return 'A';
            if ($asc >= -20283 && $asc <= -19776)
                return 'B';
            if ($asc >= -19775 && $asc <= -19219)
                return 'C';
            if ($asc >= -19218 && $asc <= -18711)
                return 'D';
            if ($asc >= -18710 && $asc <= -18527)
                return 'E';
            if ($asc >= -18526 && $asc <= -18240)
                return 'F';
            if ($asc >= -18239 && $asc <= -17923)
                return 'G';
            if ($asc >= -17922 && $asc <= -17418)
                return 'H';
            if ($asc >= -17417 && $asc <= -16475)
                return 'J';
            if ($asc >= -16474 && $asc <= -16213)
                return 'K';
            if ($asc >= -16212 && $asc <= -15641)
                return 'L';
            if ($asc >= -15640 && $asc <= -15166)
                return 'M';
            if ($asc >= -15165 && $asc <= -14923)
                return 'N';
            if ($asc >= -14922 && $asc <= -14915)
                return 'O';
            if ($asc >= -14914 && $asc <= -14631)
                return 'P';
            if ($asc >= -14630 && $asc <= -14150)
                return 'Q';
            if ($asc >= -14149 && $asc <= -14091)
                return 'R';
            if ($asc >= -14090 && $asc <= -13319)
                return 'S';
            if ($asc >= -13318 && $asc <= -12839)
                return 'T';
            if ($asc >= -12838 && $asc <= -12557)
                return 'W';
            if ($asc >= -12556 && $asc <= -11848)
                return 'X';
            if ($asc >= -11847 && $asc <= -11056)
                return 'Y';
            if ($asc >= -11055 && $asc <= -10247)
                return 'Z';
            return self::rare_words($asc);
        } catch (\Exception $e) {
            return null;
        }
    }

    //百家姓中的生僻字
    public static function rare_words($asc = '')
    {
        $rare_arr = [
            -3652 => ['word' => "窦", 'first_char' => 'D'],
            -8503 => ['word' => "奚", 'first_char' => 'X'],
            -9286 => ['word' => "酆", 'first_char' => 'F'],
            -7761 => ['word' => "岑", 'first_char' => 'C'],
            -5128 => ['word' => "滕", 'first_char' => 'T'],
            -9479 => ['word' => "邬", 'first_char' => 'W'],
            -5456 => ['word' => "臧", 'first_char' => 'Z'],
            -7223 => ['word' => "闵", 'first_char' => 'M'],
            -2877 => ['word' => "裘", 'first_char' => 'Q'],
            -6191 => ['word' => "缪", 'first_char' => 'M'],
            -5414 => ['word' => "贲", 'first_char' => 'B'],
            -4102 => ['word' => "嵇", 'first_char' => 'J'],
            -8969 => ['word' => "荀", 'first_char' => 'X'],
            -4938 => ['word' => "於", 'first_char' => 'Y'],
            -9017 => ['word' => "芮", 'first_char' => 'R'],
            -2848 => ['word' => "羿", 'first_char' => 'Y'],
            -9477 => ['word' => "邴", 'first_char' => 'B'],
            -9485 => ['word' => "隗", 'first_char' => 'K'],
            -6731 => ['word' => "宓", 'first_char' => 'M'],
            -9299 => ['word' => "郗", 'first_char' => 'X'],
            -5905 => ['word' => "栾", 'first_char' => 'L'],
            -4393 => ['word' => "钭", 'first_char' => 'T'],
            -9300 => ['word' => "郜", 'first_char' => 'G'],
            -8706 => ['word' => "蔺", 'first_char' => 'L'],
            -3613 => ['word' => "胥", 'first_char' => 'X'],
            -8777 => ['word' => "莘", 'first_char' => 'S'],
            -6708 => ['word' => "逄", 'first_char' => 'P'],
            -9302 => ['word' => "郦", 'first_char' => 'L'],
            -5965 => ['word' => "璩", 'first_char' => 'Q'],
            -6745 => ['word' => "濮", 'first_char' => 'P'],
            -4888 => ['word' => "扈", 'first_char' => 'H'],
            -9309 => ['word' => "郏", 'first_char' => 'J'],
            -5428 => ['word' => "晏", 'first_char' => 'Y'],
            -2849 => ['word' => "暨", 'first_char' => 'J'],
            -7206 => ['word' => "阙", 'first_char' => 'Q'],
            -4945 => ['word' => "殳", 'first_char' => 'S'],
            -9753 => ['word' => "夔", 'first_char' => 'K'],
            -10041 => ['word' => "厍", 'first_char' => 'S'],
            -5429 => ['word' => "晁", 'first_char' => 'C'],
            -2396 => ['word' => "訾", 'first_char' => 'Z'],
            -7205 => ['word' => "阚", 'first_char' => 'K'],
            -10049 => ['word' => "乜", 'first_char' => 'N'],
            -10015 => ['word' => "蒯", 'first_char' => 'K'],
            -3133 => ['word' => "竺", 'first_char' => 'Z'],
            -6698 => ['word' => "逯", 'first_char' => 'L'],
            -9799 => ['word' => "俟", 'first_char' => 'Q'],
            -6749 => ['word' => "澹", 'first_char' => 'T'],
            -7220 => ['word' => "闾", 'first_char' => 'L'],
            -10047 => ['word' => "亓", 'first_char' => 'Q'],
            -10005 => ['word' => "仉", 'first_char' => 'Z'],
            -3417 => ['word' => "颛", 'first_char' => 'Z'],
            -6431 => ['word' => "驷", 'first_char' => 'S'],
            -7226 => ['word' => "闫", 'first_char' => 'Y'],
            -9293 => ['word' => "鄢", 'first_char' => 'Y'],
            -6205 => ['word' => "缑", 'first_char' => 'G'],
            -9764 => ['word' => "佘", 'first_char' => 'S'],
            -9818 => ['word' => "佴", 'first_char' => 'N'],
            -9509 => ['word' => "谯", 'first_char' => 'Q'],
            -3122 => ['word' => "笪", 'first_char' => 'D'],
            -9823 => ['word' => "佟", 'first_char' => 'T'],
            -8785 => ['word' => "莜", 'first_char' => 'Y'],
            -5681 => ['word' => "橄", 'first_char' => 'G'],
            -8527 => ['word' => "薇", 'first_char' => 'W'],
            -10003 => ['word' => "仨", 'first_char' => 'S'],
        ];
        if (array_key_exists($asc, $rare_arr) && $rare_arr[$asc]['first_char']) {
            return $rare_arr[$asc]['first_char'];
        }
        return null;
    }
}