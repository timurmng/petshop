<?php
/**
 * Created by PhpStorm.
 * User: timurmengazi
 * Date: 12.01.2019
 * Time: 20:43
 */

use yii\helpers\Html;


$this->title = Html::encode($model->nume_prd);
?>

<div class="product">
    <h2 class="page-header"><?php echo Html::encode($model->nume_prd); ?></h2>
    <div class="col-md-9">
        <p class="product-display">
            <?php
            try {
                echo \yii\widgets\DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'attribute' => 'descriere_prd'
                        ],
                        [
                            'attribute' => 'tip_prd',
                            'value' => function ($model) {
                                switch ($model->tip_prd) {
                                    case 1:
                                        return 'Hrană uscată';
                                    case 2:
                                        return 'Hrană umedă';
                                    case 3:
                                        return 'Hrană vie';
                                }
                                return true;
                            }
                        ],
                        [
                            'attribute' => 'idanm_prd',
                            'value' => $model->animal->denumire_anm,
                        ],
                        [
                            'attribute' => 'pret_prd',
                            'value' => $model->pret_prd . ' Lei',
                        ],
                        [
                            'attribute' => 'stoc_prd',
                            'value' => $model->stoc_prd . ' Bucăți'
                        ]
                    ]

                ]);
            } catch (Exception $e) {
                print_r($e->getMessage());
            }
            ?>

            <a href="javascript:void(0)" class="btn btn-default" id="query">Arată query</a>
            <p id="show-query" style="text-align: left"></p>

    </div>
    <!-- IMG -->
    <div class="col-md-3">
        <div class="padding">
            <img class="img-thumbnail" src="/uploads/<?php echo $model->imagine_prd; ?>" alt="">
        </div>
    </div>
</div>
<br>
<br clear="all  "/>
<script>
    let query = document.getElementById('query');
    query.addEventListener('click', toggleQuery);
    let status = 0;
    let par = document.getElementById('show-query');

    function toggleQuery(e) {
        if (status === 0) {
            par.innerText = <?php echo json_encode($sql); ?>;
            query.innerText = "Ascunde query";
            status = 1;
        } else {
            status = 0;
            par.innerText = "";
            query.innerText = "Arată query";
        }
    }
</script>
