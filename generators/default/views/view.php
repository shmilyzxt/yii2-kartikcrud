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

use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">
 
    <?= "<?= " ?>DetailView::widget([
        'model' => $model,
        'condensed'=>false,
        'hover'=>true,
        'mode'=>Yii::$app->request->get('edit')=='t' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'查看和修改',
            'type'=>DetailView::TYPE_INFO,
        ],
        'deleteOptions'=>[
            'url'=>['deletefromdetail','<?=substr($actionParams,1)?>'=>$model->id],
            'lable' =>'删除',
            /*'data'=>[
            'confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'),
            'method'=>'post',
            ],*/
            /*'params' => ['id' => $model->id],*/
        ],
        'updateOptions'=>[
            'url'=>['detailview'],
        ],
        'container' => ['id'=>'kv-demo'],
        //'formOptions' => ['action' => \yii\helpers\Url::to("/mgr/history/detailviewdelete")],// your action to delete
        'enableEditMode'=>true,
        //'buttons1' =>'{update}',
        'attributes' => [
<?php
            if (($tableSchema = $generator->getTableSchema()) === false) {
                foreach ($generator->getColumnNames() as $name) {
                    echo "            '" . $name . "',\n";
                }
            } else {
                foreach ($generator->getTableSchema()->columns as $column) {
                    $format = $generator->generateColumnFormat($column);
                    echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                }
            }
            ?>
        ],
    ]) ?>

</div>