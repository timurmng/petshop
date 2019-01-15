<?php
/**
 * Created by PhpStorm.
 * User: timurmengazi
 * Date: 01.01.2019
 * Time: 17:58
 */

/* @var $products array */

use yii\helpers\Html;

$this->title = 'Produsele noastre';

?>

<h2 class="page-header">
    <?php echo Html::encode($this->title); ?>
    <span class="pull-right">
            <a href="/produs/index?filter=PRET_ASC" class="btn btn-default">Preț crescător</a>
            <a href="/produs/index?filter=PRET_DESC" class="btn btn-default">Preț descrescător</a>
            <a href="/produs/index?filter=NUM_ASC" class="btn btn-default">Alfabetic (A-Z)</a>
            <a href="/produs/index?filter=NUM_DESC" class="btn btn-default">Alfabetic (Z-A)</a>
        </span>
</h2>

<br>
<br>
<?php foreach ($products as $product) : ?>
    <div class="col-md-3">

        <div class="card img-thumbnail mb-3" style="max-width: 18rem;">
            <img class="card-img-top" src="/uploads/<?php echo $product['imagine_prd']; ?>">

            <h4 class="card-title">
                <a href="/produs/view/<?php echo $product['id_prd']; ?>" class="food-link">
                    <?php echo Html::encode($product['nume_prd']); ?>
                </a>
            </h4>

            <br>

            <div class="card-body">
                <h3>
                    <p style="text-align: center"><?php echo Html::encode($product['pret_prd']); ?> Lei</p>
                </h3>
            </div>

        </div>
    </div>
<?php endforeach; ?>

<br clear="all">
<br>
<div class="container">
    <a href="javascript:void(0)" class="btn btn-default" id="query">Arată query</a>
    <p id="show-query" style="text-align: left; padding-top:6px;"></p>
</div>
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

