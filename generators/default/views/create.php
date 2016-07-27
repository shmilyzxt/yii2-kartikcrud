<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

?>

<div class="panel panel-info">
    <div class="panel-heading"><h3 class="panel-title">创建</h3></div>
    <div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-create">
        <?= "<?= " ?>$this->render('_form', [
        'model' => $model,
        ]) ?>
    </div>
</div>
