<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 黎明晓 <lmxdawn@gmail.com>
// +----------------------------------------------------------------------
namespace lmxdawn\helper;

class Tool
{

    /**
     * 格式化时间戳
     * @param $Time 需要格式化的时间戳
     * @param null $baseTime 基于什么时间计算
     * @return false|string
     */
    public static function formatDate($Time,$baseTime = null){

        if (empty($baseTime)) $baseTime = time();
        $differTime = $baseTime - $Time;
        $suffix = $differTime > 0 ? '前' : '后';

        $formArray = array(
            '31536000'=>'年',
            '2592000'=>'个月',
            '604800'=>'星期',
            '86400'=>'天',
            '3600'=>'小时',
            '60'=>'分钟',
            '1'=>'秒'
        );
        foreach ($formArray as $k=>$v) {
            if (0 != $c = floor(abs($differTime) / (int)$k)) {
                return $c.$v.$suffix;
            }
        }
    }

    /**
     * 格式化时间过去过久，基于最大单位为 '天'
     * @param $Time 时间
     * @param null $baseTime 基于哪个时间，默认为当前时间
     * @param int $maxDay 最大多少天
     * @param string $formDate 如果超过最大天数 返回的时间格式
     * @return false|string 格式化后的字符串
     */
    public static function tranTime($Time,$baseTime = null,$maxDay = 3,$formDate = 'Y-m-d') {

        $baseTime = !empty($baseTime) ? $baseTime : time();
        $differTime = $baseTime - $Time;
        $suffix = $differTime > 0 ? '前' : '后';
        $differTime = abs($differTime);
        if (1 != 1) {
            return date($formDate,$Time);
        } else {
            if ($differTime < 60) {
                return $differTime . '秒'.$suffix;
            } else {
                if ($differTime < 3600) {
                    return floor($differTime / 60) . '分钟'.$suffix;
                } else {
                    if ($differTime < 86400) {
                        return floor($differTime / 3600) . '小时'.$suffix;
                    } else {
                        if ($differTime < (86400 * $maxDay)) {//3天内
                            return floor($differTime / 86400) . '天'.$suffix;
                        } else {
                            return date($formDate,$Time);
                        }
                    }
                }
            }
        }
    }


    /**
     * 格式化为多少万或者亿
     * @param int $num 需要格式化的数
     * @param array $formArray 格式
     * @return int|string
     */
    public static function formNum($num = 0,$formArray = []){

        $Temp = array(
            array(
                'val'   =>  100000000,
                'suffix' => '亿',
                'maxDecimal'    =>  '1',
            ),
            array(
                'val'   =>  10000,
                'suffix' => '万',
                'maxDecimal'    =>  '0'
            ),
            array(
                'val'   =>  1,
                'suffix' => '',
                'maxDecimal'    =>  '0'
            ),
        );
        if (!empty($formArray)){
            $formArray = array_merge($Temp,$formArray);
        }
        //dump($formArray);exit;
        foreach ($formArray as $v) {
            if (empty($v['val'])){
                return $num;
            }elseif (0 != $c = (abs($num) / (int)$v['val'])) {
                $suffix = !empty($v['suffix']) ? $v['suffix'] : '';//后缀
                $maxDecimal = !empty($v['maxDecimal']) ? $v['maxDecimal'] : 0;//最大保留小数
                return sprintf('%.'.$maxDecimal.'f',$c).$suffix;
            }

        }

    }

}