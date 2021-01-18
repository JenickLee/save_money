<?php
/**
 * Created by PhpStorm.
 * User: Jenick
 * DateTime: 2020/4/15 15:49
 */
namespace app\common\lib;

class BuildId
{
    /**
     * Notes:创建63进制的唯一id
     * User: Jenick
     * Date: 2019/06/18
     * Time: 17:01
     * @return mixed
     */
    public static function createId() {
        return self::decTo63(base_convert(md5(uniqid()), 16, 10));
    }

    /**
     * Notes:十进制的字符串转63进制
     * User: Jenick
     * Date: 2019/06/18
     * Time: 17:01
     * @param $str
     * @return string
     */
    public static function decTo63($str)
    {
        $array63 = [
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j',
            'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't',
            'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D',
            'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N',
            'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X',
            'Y', 'Z'
        ];

        $ayyayLen = count($array63);
        $result = '';
        $quotient = $str;
        $divisor = $str;
        $flag = true;
        while ($flag) {
            $len = strlen($divisor);
            $pos = 1;
            $quotient = 0;
            $div = substr($divisor, 0, 2);
            $remainder = $div[0];
            while ($pos < $len) {
                $div = $remainder == 0 ? $divisor[$pos] : $remainder.$divisor[$pos];
                $remainder = $div % $ayyayLen;
                $quotient = $quotient.floor($div / $ayyayLen);
                $pos++;
            }
            $quotient = self::trimLeftZeros($quotient);
            $divisor = "$quotient";
            $result = $array63[$remainder].$result;
            if (strlen($divisor) <= 2) {
                if ($divisor < $ayyayLen - 1) {
                    $flag = false;
                }
            }
        }
        $result = $array63[$quotient].$result;
        $result = self::trimLeftZeros($result);
        return $result;
    }

    /**
     * Notes:裁剪左边零
     * User: Jenick
     * Date: 2019/12/25
     * Time: 13:42
     * @param $str
     * @return string
     */
    public static function trimLeftZeros($str)
    {
        $str = ltrim($str, '0');
        if (empty($str)) {
            $str = '0';
        }
        return $str;
    }
}