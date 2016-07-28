<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$modelClass = StringHelper::basename($generator->modelClass);
$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
$actionParams = $generator->generateActionParams();

echo "<?php\n";

?>
use yii\helpers\Url;
use yii\helpers\Html;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    <?php
    $count = 0;
    foreach ($generator->getColumnNames() as $name) {
        if ($name=='id'||$name=='created_at'||$name=='updated_at'){
            echo "    // [\n";
            echo "        // 'class'=>'\kartik\grid\DataColumn',\n";
            echo "        // 'attribute'=>'" . $name . "',\n";
            echo "    // ],\n";
        } else if (++$count < 6) {
            echo "    [\n";
            echo "        'class'=>'\kartik\grid\DataColumn',\n";
            echo "        'attribute'=>'" . $name . "',\n";
            echo "        'label'=>'" . $name . "',\n";
            echo "    ],\n";
        } else {
            echo "    // [\n";
            echo "        // 'class'=>'\kartik\grid\DataColumn',\n";
            echo "        // 'attribute'=>'" . $name . "',\n";
            echo "    // ],\n";
        }
    }
    ?>
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
                return Url::to([$action,'<?=substr($actionParams,1)?>'=>$key]);
        },

    <?php if (1==2) {?>
        'template' => \shmilyzxt\kartikcrud\ShmilyzxtHelper::filterActionColumn(['view','delete']),
    <?php }else{?>
        //动作栏按钮设定（默认为：查看，禁用，删除）
        'template' => \shmilyzxt\kartikcrud\ShmilyzxtHelper::filterActionColumn(['view','activate','inactivate', 'delete']),
        'buttons' => [
            'activate' => function($url, $model) {
                //if ($model->status == 1) {
                //    return '';
                //}
                $options = [
                    'role'=>'modal-remote',
                    'title'=>'启用',
                    'data-confirm'=>false,
                    'data-method'=>false,// for overide yii data api
                    'data-request-method'=>'post',
                    'data-toggle'=>'tooltip',
                    'data-confirm-title'=>'确认操作',
                    'data-confirm-message'=>'你确定要启用吗？'
                ];
                return Html::a('<span class="glyphicon glyphicon-ok"></span>', $url, $options);
            },
            'inactivate' => function($url, $model) {
                //if ($model->status == 0) {
                    //return '';
                //}
                $options = [
                    'role'=>'modal-remote',
                    'title'=>'禁用',
                    'data-confirm'=>false,
                    'data-method'=>false,// for overide yii data api
                    'data-request-method'=>'post',
                    'data-toggle'=>'tooltip',
                    'data-confirm-title'=>'确认操作',
                    'data-confirm-message'=>'你确定要禁用吗？'
                ];
                return Html::a('<span class="glyphicon glyphicon-cog"></span>', $url, $options);
            },
        ],
    <?php }?>
        'viewOptions'=>['role'=>'modal-remote','title'=>'查看及修改','data-toggle'=>'tooltip'],
        //'updateOptions'=>['role'=>'modal-remote','title'=>'更新', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'删除',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'确认操作',
                          'data-confirm-message'=>'你确定要删除该记录吗？'],
    ],

];   