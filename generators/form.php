<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator shmilyzxt\kartikcrud\generators\Generator */

echo '<h3>填写生成配置信息</h3>';
echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'searchModelClass');
echo $form->field($generator, 'controllerClass');
echo $form->field($generator, 'viewPath');
echo $form->field($generator, 'baseControllerClass');
echo $form->field($generator, 'enableI18N')->checkbox();
//echo $form->field($generator, 'isActiveOpen')->checkbox(['label'=>'是否开启生成启用，禁用功能']);
echo $form->field($generator, 'messageCategory');
