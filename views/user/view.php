<?php
/* @var $user array */
/* @var $this \yii\web\View */
use app\models\User;
$this->title = 'Vezi profil';
?>

<h1 class="page-title">
    <?= $model[0]['nume_usr'] . ' ' . $model[0]['prenume_usr'] ?>
    <span class="pull-right">
            <a href="javascript:void(0)" class="btn btn-default" id="query">Arată query</a>
            <a href="/user/edit" class="btn btn-default">Editează profilul</a>
        </span>
</h1>
<br>
<p id="show-query">
</p>
<br>
<?php
try {
    echo \yii\widgets\DetailView::widget([
        'model' => $model[0],
        'attributes' => [
            [
                'attribute' => 'id_usr',
                'label' => 'ID',
                'visible' => Yii::$app->user->identity->type_usr == User::TYPE_ADMINISTRATOR ? true : false
            ],
            [
                'attribute' => 'email_usr',
                'label' => 'Email',
            ],
            [
                'attribute' => 'datanastere_usr',
                'label' => 'Data nașterii',
            ],
            [
                'attribute' => 'sex_usr',
                'label' => 'Sex',
                'value' => function ($model) {
                    return $model['sex_usr'] == 'M' ? 'Masculin' : 'Feminin';
                }
            ],
            [
                'attribute' => 'tara_usr',
                'label' => 'Țara',
            ],
            [
                'attribute' => 'oras_usr',
                'label' => 'Oraș',
            ],
            [
                'attribute' => 'type_usr',
                'visible' => Yii::$app->user->identity->type_usr == User::TYPE_ADMINISTRATOR ? true : false,
                'label' => 'Tip',
                'value' => function ($model) {
                    return $model['type_usr'] == User::TYPE_ADMINISTRATOR ? 'Administrator' : ($model['type_usr'] == User::TYPE_USER ? 'Utilizator' : 'Dezactivat');
                }
            ],
            [
                'attribute' => 'lastlogin_usr',
                'visible' => Yii::$app->user->identity->type_usr == User::TYPE_ADMINISTRATOR ? true : false,
                'label' => 'Ultima logare',
            ]
        ],
    ]);
} catch (Exception $e) {
    print_r($e->getMessage());
}
?>

<?php if (isset($model[0]['id_crd'])) : ?>
    <h2 class="page-header">Carduri</h2>

    <?php foreach ($model as $item) : ?>
        <?php try {
            echo \yii\widgets\DetailView::widget([
                'model' => $item,
                'attributes' => [
                    [
                        'attribute' => 'id_crd',
                        'visible' => yii::$app->user->identity->type_usr == User::TYPE_ADMINISTRATOR ? true : false,
                        'label' => 'ID Card'
                    ],
                    [
                        'attribute' => 'serial_crd',
                        'label' => 'Seria Cardului'
                    ],
                    [
                        'attribute' => 'holder_crd',
                        'label' => 'Nume Deținător'
                    ],
                    [
                        'attribute' => 'expiration_crd',
                        'label' => 'Data expirării'
                    ],
                ]
            ]);
        } catch (Exception $e) {
            die(print_r($e->getMessage()));
        } ?>
        <div class="form-group">
            <span class="col-lg-pull-6">
                <a href="/card/edit?serie='<?php echo urlencode($item['serial_crd']); ?>'" class="btn btn-default">Modifică datele cardului</a>
            </span>
            <span class="pull-right">
                <a href="/card/delete?serie='<?php echo $item['serial_crd'] ?>'" class="btn btn-danger"
                   onclick="return(confirm('Ești sigur?'))">Șterge cardul</a>
            </span>
        </div>
    <?php endforeach; ?>

<?php endif; ?>

<br>
<div class="form-group">
    <a href="/card/add" class="btn btn-success">Adaugă un card</a>
</div>
<br>

<script>
    let query = document.getElementById('query');
    query.addEventListener('click', toggleQuery);
    let status = 0;
    let par = document.getElementById('show-query');
    function toggleQuery(e) {
        if (status === 0) {
            par.innerText = <?php echo $comanda; ?>;
            query.innerText = "Ascunde query";
            status = 1;
        } else {
            status = 0;
            par.innerText = "";
            query.innerText = "Arată query";
        }
    }
</script>