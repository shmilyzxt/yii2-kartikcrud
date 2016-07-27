<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->attributes();
/*if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}*/

echo "<?php\n";
?>
use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form kartik\form\ActiveForm */


?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

    <?= "<?php " ?>$form = ActiveForm::begin(['id' => 'form-create']); ?>
    <table class="table table-hover table-bordered table-striped detail-view">
        <tbody>
<?php foreach ($generator->getColumnNames() as $attribute) {
    if (in_array($attribute, $safeAttributes)) {

        echo "    <tr>\n<th style='width: 20%; text-align: right; vertical-align: middle;'>\n<?= Html::activeLabel(\$model, '".$attribute."', ['label'=>'".$model->getAttributeLabel($attribute)."', 'class'=>'']) ?></th>\n";
        echo "    <td>\n<div class='kv-form-attribute'>";
        echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
        echo "    </div>\n</td>\n</tr>";
    }
} ?>  
	<?='<?php if (!Yii::$app->request->isAjax){ ?>'."\n"?>
	  	<div class="form-group">
	        <?= "<?= " ?>Html::submitButton($model->isNewRecord ? <?= $generator->generateString('Create') ?> : <?= $generator->generateString('Update') ?>, ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?="<?php } ?>\n"?>
        </tbody>
    </table>
    <?= "<?php " ?>ActiveForm::end(); ?>
</div>
