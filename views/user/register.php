<?php
/* @var $this \yii\web\View
 * @var $model \app\models\User
 * @var $form \yii\widgets\ActiveForm
 */

$this->title = 'Înregistrare';
?>

<h2 class="page-header">Înregistrare</h2>
<div class="user-register">
    <?php $form = \yii\widgets\ActiveForm::begin(); ?>

    <?= $form->field($model, 'nume_usr'); ?>
    <?= $form->field($model, 'prenume_usr'); ?>
    <?= $form->field($model, 'email_usr'); ?>
    <?= $form->field($model, 'parola_usr')->passwordInput(); ?>
    <?= $form->field($model, 'datanastere_usr')->input('test', [
            'placeholder' => 'AAAA-LL-ZZ'
    ]) ?>
    <?= $form->field($model, 'sex_usr')->dropDownList([
        'M' => 'Masculin',
        'F' => 'Feminin',
        'A' => 'Altul'
    ], ['prompt' => 'Selectați sexul']); ?>
    <?= $form->field($model, 'tara_usr'); ?>
    <?= $form->field($model, 'oras_usr'); ?>

    <div class="form-group">
        <?= \yii\bootstrap\Html::submitButton('Înregistrează-te!', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php \yii\widgets\ActiveForm::end(); ?>
</div>
