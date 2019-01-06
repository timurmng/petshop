<?php
/* @var $model \app\models\Card */
/* @var $this \yii\web\View */

$this->title = 'Modifică card';
?>

<h2 class="page-header">Modifică card</h2>

<div class="card-add">

    <?php $form = \yii\widgets\ActiveForm::begin(); ?>

    <?= $form->field($model, 'serial_crd'); ?>
    <?= $form->field($model, 'holder_crd'); ?>
    <?= $form->field($model, 'expiration_crd'); ?>

    <div class="form-group">
        <?= \yii\bootstrap\Html::submitButton('Modifică card', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php \yii\widgets\ActiveForm::end(); ?>
</div>