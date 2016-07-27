<?php
/**
 * Created by PhpStorm.
 * User: zhenxiaotao
 * Date: 2016/7/27
 * Time: 16:41
 */

namespace shmilyzxt\kartikcrud;


class ShmilyzxtHelper
{
    public static function filterActionColumn($buttons = [], $user = null)
    {
        if (is_array($buttons)) {
            $result = [];
            foreach ($buttons as $button) {
                
                    $result[] = "{{$button}}";
                
            }
            return implode(' ', $result);
        }
        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($user) {
            return  "{{$matches[1]}}";
        }, $buttons);
    }
}