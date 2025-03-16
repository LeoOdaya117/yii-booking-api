<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => array_merge(
            [
                ['label' => 'Bookings', 'url' => ['/bookings/index']],
                ['label' => 'Rooms', 'url' => ['/rooms/index']],

            ],
            Yii::$app->user->isGuest
                ? [['label' => 'Login', 'url' => ['/site/login']], ['label' => 'Signup', 'url' => ['/site/signup']]]
                : [['label' => 'Logout (' . Html::encode(Yii::$app->user->identity->getName()) . ')', 
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']]
                ]
        ),
    ]);
    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
    <div class="alert-container" style="display: none;">
         <?= Alert::widget() ?>
    </div>
    
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; My Company <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>

<script>
    var alertContainer = document.querySelector('.alert-container');
        alertContainer.style.display = 'block';
        setTimeout(function() {
            alertContainer.style.transition = 'opacity 3s';
            alertContainer.style.opacity = '0';
            setTimeout(function() {
                alertContainer.style.display = 'none';
            }, 3000);
        }, 2000);
</script>
</body>

</html>
<?php $this->endPage() ?>
