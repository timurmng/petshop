<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    try {
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => 'Înregistrează-te', 'url' => ['/user/register/'], 'visible' => yii::$app->user->isGuest],
                ['label' => 'Acasă', 'url' => ['/site/index']],
                ['label' => 'Carduri', 'visible' => yii::$app->user->isGuest ? false : true, 'items' => [
                    ['label' => 'Vezi carduri', 'url' => ['/card/index']],
                    ['label' => 'Adaugă card', 'url' => ['/card/add']],
                    ['label' => 'Admin', 'url' => ['/card/admin'], 'visible' => yii::$app->user->isGuest ? false : yii::$app->user->identity->type_usr == \app\models\User::TYPE_ADMINISTRATOR ? true : false],
                ],
                ],
                ['label' => 'Produse', 'items' => [
                    ['label' => 'Catalog', 'url' => ['/produs/']],
                    ['label' => 'Adauga produs', 'url' => ['/produs/add'], 'visible' => yii::$app->user->isGuest ? false : true],
                    ['label' => 'Admin', 'url' => ['/produs/admin'], 'visible' => yii::$app->user->isGuest ? false : yii::$app->user->identity->type_usr == \app\models\User::TYPE_ADMINISTRATOR ? true : false],
                ]],
                Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
                ) : (
                    '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->email_usr . ')',
                        ['class' => 'btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
                )
            ],
        ]);
    } catch (Exception $e) {
        print_r($e->getMessage());
    }
    NavBar::end();
    ?>

    <div class="container">
        <?php try {
            echo Alert::widget();
        } catch (Exception $e) {
        } ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
