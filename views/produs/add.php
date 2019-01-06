<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model app\models\Produs
 * @var $form ActiveForm
 * @var $typeFood array
 * @var $typeAnimal array
 */
$this->title = 'Adaugă produs';
?>
<h2 class="page-header">Adaugă produs</h2>
<div class="company-add">
    <?php $form = ActiveForm::begin(['options' => [
        'enableClientValidation' => false,
        'enctype' => 'multipart/form-data'
    ]
    ]) ?>
    <?= $form->field($model, 'nume_prd')->input('text', ['placeholder' => 'Numele produsului']) ?>
    <?= $form->field($model, 'descriere_prd')->input('text', ['placeholder' => 'O descriere succintă a produsului']) ?>
    <?= $form->field($model, 'idanm_prd')->dropDownList($typeAnimal, [
            'prompt' => 'Alege un animal'
    ]) ?>
    <?= $form->field($model, 'tip_prd')->dropDownList($typeFood,[
            'prompt' => 'Alege tipul produsului'
    ]) ?>
    <?= $form->field($model, 'pret_prd')->input('text', ['placeholder' => 'Prețul exprimat în lei']) ?>
    <?= $form->field($model, 'stoc_prd')->input('text', ['placeholder' => 'Ce cantiate doriți să o expuneți']) ?>
    <?= $form->field($model, 'imagine_prd')->fileInput(['accept' => 'image/*']) ?>
    <div class="form-group">
        <?= Html::submitButton('Adaugă', ['class' => 'btn btn-primary']); ?>
    </div>
    <? Activeform::end(); ?>
</div>
