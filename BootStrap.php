<?php
namespace shmilyzxt\kartikcrud;

use \Yii;
use yii\base\BootstrapInterface;

/**
 * bootstrap检测和设置模块，添加gii的生成器
 * @author shmilyzxt <49783121@qq.com>
 * @since 1.0
 */

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app){
        Yii::setAlias("@kartikcrud", __DIR__);
        Yii::setAlias("@shmilyzxt/kartikcrud", __DIR__);
        if($app->hasModule('gii')){
            if (!isset($app->getModule('gii')->generators['kartikcrud'])) {
                $app->getModule('gii')->generators['kartikcrud'] = 'shmilyzxt\kartikcrud\generators\Generator';
                Yii::$app->setModule("gridview", ['class'=>'kartik\grid\Module']);
            }
        }
    }
}