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
        <a href="/produs/index?filter=ASC" class="btn btn-primary">Preț crescător</a>
        <a href="/produs/index?filter=DESC" class="btn btn-default">Preț descrescător</a>
    </span>
</h2>

<?php foreach ($products as $product) : ?>
    <div class="col-md-2">
        <h3>
            <a href="/produs/view/<?php echo $product['id_prd']; ?>">
                <?php echo Html::encode($product['nume_prd']); ?>
            </a>
        </h3>

        <img src="/uploads/<?php echo $product['imagine_prd']; ?>">


    </div>
<?php endforeach; ?>
