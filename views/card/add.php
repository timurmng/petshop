<?php

/* @var $model \app\models\Card */
/* @var $this \yii\web\View */

$this->title = 'Adaugă card';
?>

<h2 class="page-header">Adaugă card</h2>

<div class="card-add">

    <?php $form = \yii\widgets\ActiveForm::begin(); ?>

    <?= $form->field($model, 'serial_crd'); ?>
    <?= $form->field($model, 'holder_crd'); ?>
    <?= $form->field($model, 'expiration_crd'); ?>

    <div class="form-group">
        <?= \yii\bootstrap\Html::submitButton('Adaugă card', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php \yii\widgets\ActiveForm::end(); ?>
</div>
