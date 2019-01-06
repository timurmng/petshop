<?php
/* @var $this \yii\web\View
 * @var $model \app\models\User
 * @var $form \yii\widgets\ActiveForm
 */

$this->title = 'Modifică Profilul';
?>

<h2 class="page-header">Modifică Profil</h2>
<div class="user-register">
    <?php $form = \yii\widgets\ActiveForm::begin(); ?>

    <?= $form->field($model, 'nume_usr'); ?>
    <?= $form->field($model, 'prenume_usr'); ?>
    <?= $form->field($model, 'email_usr'); ?>
    <?= $form->field($model, 'datanastere_usr'); ?>
    <?= $form->field($model, 'sex_usr'); ?>
    <?= $form->field($model, 'tara_usr'); ?>
    <?= $form->field($model, 'oras_usr'); ?>

    <div class="form-group">
        <?= \yii\bootstrap\Html::submitButton('Modifică!', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php \yii\widgets\ActiveForm::end(); ?>
</div>
