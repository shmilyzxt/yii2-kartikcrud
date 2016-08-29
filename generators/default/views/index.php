<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
echo "<?php\n";
?>
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use shmilyzxt\kartikcrud\CrudAsset;
use shmilyzxt\kartikcrud\BulkButtonWidget;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
    <div id="ajaxCrudDatatable">
        <?="<?="?>GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                    ['role'=>'modal-remote','title'=> '创建 <?= Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>','class'=>'btn btn-default']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'重置']).
                    '{toggleData}'.
                    '{export}'
                ],
            ],
            'containerOptions'=>['style'=>'overflow: auto'],
            'headerRowOptions'=>['class'=>'kartik-sheet-style'],
            'filterRowOptions'=>['class'=>'kartik-sheet-style'],
            'bordered'=>true,
            'striped'=>true,
            'condensed'=>true,
            'responsive'=>true,
            'hover'=>true,
            //'showPageSummary'=>true,
            'resizableColumns'=>true,
            //'persistResize'=>true,
            'floatHeader'=>false,
            'panel' => [
                'type' => 'primary', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> <?= Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?> 列表',
                'before'=>Html::a('创建', ['create'],
                 ['role'=>'modal-remote','title'=> '创建 <?= Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>','class'=>'btn btn-success']),
                'after'=>BulkButtonWidget::widget([
                            'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; 删除选中项',
                                ["bulk-delete"] ,
                                [
                                    "class"=>"btn btn-danger btn-xs",
                                    'role'=>'modal-remote-bulk',
                                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                    'data-request-method'=>'post',
                                    'data-confirm-title'=>'确认操作',
                                    'data-confirm-message'=>'你确定要执行删除操作吗？'
                                ]),
                        ]).                        
                        '<div class="clearfix"></div>',
            ],

            //添加高级分页支持
            'filterSelector' => "select[name='".$dataProvider->getPagination()->pageSizeParam."'],input[name='".$dataProvider->getPagination()->pageParam."']",
            'pager' => [
                'class' => \shmilyzxt\kartikcrud\LinkPager::className(),
                'template' => '{pageButtons} {customPage} {pageSize}',
                'pageSizeList' => [10, 20, 30, 50],
                'customPageWidth' => 50,
                'customPageBefore' => '跳转到',
                'customPageAfter' => ' 页 ',
                'firstPageLabel' => '首页',
                'lastPageLabel' => '末页',
            ],
        ])<?="?>\n"?>
    </div>
</div>
<?='<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
    "options" =>[\'data-backdrop \'=>\'static\',\'data-keyboard\'=>\'false\',\'z-index\'=>\'-999\'],
])?>'."\n"?>
<?='<?php Modal::end(); ?>'?>

<?php
echo "<?php\n";
?>
//引入js放在最后，应为_column.php引入了kv-checkbox.js,为了让别最后引入改写后的：kv-grid-checkbox-fix.js放在最后
CrudAsset::register($this);
?>


