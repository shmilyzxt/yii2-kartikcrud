<?php

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

use kartik\dialog\Dialog;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">
 
    <?= "<?php " ?>$pk = $model->getPrimaryKey();
        echo DetailView::widget([
        'model' => $model,
        'condensed'=>false,
        'hover'=>true,
        'mode'=>Yii::$app->request->get('edit')=='t' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'查看和修改',
            'type'=>DetailView::TYPE_INFO,
        ],

        //提示信息设置
        'alertMessageSettings'=>[
            'kv-detail-error' => 'alert alert-danger',
            'kv-detail-success' => 'alert alert-success',
            'kv-detail-info' => 'alert alert-info',
            'kv-detail-warning' => 'alert alert-warning'
        ],

        //弹框按钮设定
        'krajeeDialogSettings'=>[
            /*'options' =>[
                'size' => Dialog::SIZE_SMALL
            ],*/
            'dialogDefaults'=>[
                    Dialog::DIALOG_ALERT => [
                    'type' => Dialog::TYPE_INFO,
                    'title' => '提示',
                    'buttonLabel' => '<i class="glyphicon glyphicon-ok"></i> 确定'
                ],
                Dialog::DIALOG_CONFIRM => [
                    'type' => Dialog::TYPE_WARNING,
                    'title' => "确认",
                    'btnOKClass' => 'btn-warning',
                    'btnOKLabel' => '<i class="glyphicon glyphicon-ok"></i> 确定',
                    'btnCancelLabel' => '<i class="glyphicon glyphicon-ban-circle"></i> 取消'
                ],
            ],
        ],

        'deleteOptions'=>[
            'url'=>['deletefromdetail','<?=substr($actionParams,1)?>'=>$pk],
            'lable' =>'删除',
        ],
        /*'updateOptions'=>[
            'url'=>['detailview'],
        ],*/
        'formOptions' =>[
            'id' => "edit-model-form",
            //'action' => ["<?=strtolower($modelClass)?>/update",<?=substr($actionParams,1)?>=>$pk],
            'action' => "<?=urldecode(Yii::$app->urlManager->createUrl([strtolower($modelClass)."/update",substr($actionParams,1) => '$pk']));?>",
        ],
        'container' => ['id'=>'kv-demo'],
        //'formOptions' => ['action' => \yii\helpers\Url::to("/mgr/history/detailviewdelete")],// your action to delete
        'enableEditMode'=>true,
        //'buttons1' =>'{update}',
        'buttons2' => '{reset} {save}',
        'attributes' => [
<?php
            if (($tableSchema = $generator->getTableSchema()) === false) {
                foreach ($generator->getColumnNames() as $name) {
                    echo "            '" . $name . "',\n";
                }
            } else {
                foreach ($generator->getTableSchema()->columns as $column) {
                    $format = $generator->generateColumnFormat($column);
                    //echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                    if($column->name == substr($actionParams,1)){
                        $reayOnly = 'true'; //主键不允许修改
                    }else{
                        $reayOnly = 'false';
                    }
                    echo "              [";
                    echo "\n";
                    echo "                  'attribute' => '".$column->name."',";
                    echo "\n";
                    echo "                  'label' => '".$column->name."',";
                    echo "\n";
                    echo "                  'displayOnly' => $reayOnly,";
                    echo "\n";
                    echo "              ],";
                    echo "\n";
                }
            }
            ?>
        ],
    ]) ?>

</div>