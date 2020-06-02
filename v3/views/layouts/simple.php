<?php

    /* @var $this \yii\web\View */
    /* @var $content string */

    use yii\helpers\Html;
    use app\assets\AppAsset;
    use yii\helpers\Url;
    use app\config\Settings;

    AppAsset::register($this);

    $this->title = Yii::$app->name;

?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>

        <!-- favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="<?= Url::to('/media/favicon/apple-touch-icon.png')?>">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= Url::to('/media/favicon/favicon-32x32.png')?>">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= Url::to('/media/favicon/favicon-16x16.png')?>">
        <link rel="manifest" href="<?= Url::to('/media/favicon/site.webmanifest')?>">
        <link rel="mask-icon" href="<?= Url::to('/media/favicon/safari-pinned-tab.svg')?>" color= "<?= Settings::$colors['faviconSafariColor'] ?>">
        <link rel="shortcut icon" href="<?= Url::to('/media/favicon/favicon.ico')?>">
        <meta name="apple-mobile-web-app-title" content="<?= Yii::$app->name ?>">
        <meta name="application-name" content="<?= Yii::$app->name ?>">
        <meta name="msapplication-TileColor" content="<?= Settings::$colors['faviconTileColor'] ?>">
        <meta name="msapplication-config" href="<?= Url::to('/media/favicon/browserconfig.xml')?>">
        <meta name="theme-color" content="<?= Settings::$colors['faviconAnotherColor'] ?>">

        <?php $this->head() ?>
    </head>

    <body>
    <?php $this->beginBody() ?>

        <main>
            <div class="logo hoverable">
                <a href="<?= Url::home() ?>">m3m3</a>
            </div>
            <div class="ui one-form container">
                <?= $content ?>
            </div>
        </main>

    <?php $this->endBody() ?>
    </body>
    
</html>
<?php $this->endPage() ?>
