<?php
namespace shmilyzxt\kartikcrud;

use \Yii;
use yii\base\BootstrapInterface;
use yii\base\Application;
use yii\base\NotSupportedException;

/**
 * bootstrap检测和设置模块，添加gii的生成器
 * @author shmilyzxt <49783121@qq.com>
 * @since 1.0
 */

class BootStrap implements BootstrapInterface
{
    public function bootstrap($app){
        //Yii::setAlias("@kartikcrud", __DIR__);
        Yii::setAlias("@shmilyzxt/kartikcrud", __DIR__);
        if(!$app->hasModule('gii')){
            throw new NotSupportedException("该扩展需要yii2-gii支持");
        }else{
            if (!isset($app->getModule('gii')->generators['kartikcrud'])) {
                $app->getModule('gii')->generators['kartikcrud'] = 'shmilyzxt\kartikcrud\generators\Generator';
            }
        }
    }
}