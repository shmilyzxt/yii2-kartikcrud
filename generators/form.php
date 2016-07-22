<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator shmilyzxt\kartikcrud\generators\Generator */

echo '<h3>配置</h3>';
echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'searchModelClass');
echo $form->field($generator, 'controllerClass');
echo $form->field($generator, 'viewPath');
echo $form->field($generator, 'baseControllerClass');
echo $form->field($generator, 'enableI18N')->checkbox();
echo $form->field($generator, 'messageCategory');
