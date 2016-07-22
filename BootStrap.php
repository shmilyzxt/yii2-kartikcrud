<?php
namespace shmilyzxt\kartikcrud;
/**
 * Created by PhpStorm.
 * User: zhenxiaotao
 * Date: 2016/7/22
 * Time: 10:15
 */
use \Yii;
use yii\base\BootstrapInterface;
use yii\base\Application;
use yii\base\NotSupportedException;


class BootStrap implements BootstrapInterface
{
    public function bootstrap(Application $app){
        Yii::setAlias("@kartikcrud", __DIR__);
        Yii::setAlias("@shmilyzxt/kartivcrud", __DIR__);
        if(!$app->hasModule('gii')){
            throw new NotSupportedException("该扩展需要yii2-gii支持");
        }else{
            if (!isset($app->getModule('gii')->generators['kartikcrud'])) {
                $app->getModule('gii')->generators['kartikcrud'] = 'shmilyzxt\kartikcrud\generators\Generator';
            }
        }
    }
}