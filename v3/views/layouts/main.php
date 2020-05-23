<?php

    /* @var $this \yii\web\View */
    /* @var $content string */

    use yii\helpers\Html;
    use yii\helpers\Url;
    use app\config\Settings;
    use app\assets\AppAsset;
    use app\assets\SidebarAsset;
    use app\components\SemanticGhostDropdown;
    use webvimark\modules\UserManagement\UserManagementModule;

    AppAsset::register($this);
    SidebarAsset::register($this);

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

<body class="pushable">
    <?php $this->beginBody() ?>

    <div class="ui left inverted vertical menu sidebar" id="sidebar">
        <div class="item">
            <a class="logo" href="<?= Url::home() ?>">m3m3</a>
            <div class="logo-subtitle" href="#">&lt;Memes y más&gt;</div>
        </div>
        <a class="item title" href="#">
            Categorias
        </a>
        <a class="item selected" data-tag="*" href="#">
            Todo
        </a>
        <a class="item" data-tag="anime" href="#">
            <i class="rocket icon"></i>
            Anime
        </a>
        <a class="item" data-tag="animales" href="#">
            <i class="paw icon"></i>
            Animales
        </a>
        <a class="item" data-tag="gifs" href="#">
            <i class="bolt icon"></i>
            GIFs
        </a>
        <a class="item" data-tag="videos" href="#">
            <i class="play icon"></i>
            Videos
        </a>
        <a class="item" data-tag="wholesome" href="#">
            <i class="star icon"></i>
            Wholesome
        </a>
        <a class="item title" href="#"></a>
        <a class="item selected type" data-type="popular" href="#">
            <i class="star icon"></i>
            Popular
        </a>
        <a class="item type" data-type="tendencia" href="#">
            <i class="rocket icon"></i>
            Tendencia
        </a>
        <a class="item type" data-type="nuevo" href="#">
            <i class="leaf icon"></i>
            Nuevo
        </a>
        <a class="item upload-post" href="upload_post.html">Subir meme ツ</a>
    </div>
    <div class="ui secondary pointing top fixed white menu" id="navbar">
        <div class="ui container">
            <div class="left menu">
                <div class="item" id="toogle-sidebar">
                    <i class="bars icon"></i>
                </div>
                <div class="item" id="home">
                    <a href="<?= Url::home() ?>"><i class="home icon"></i></a>
                </div>
            </div>
            <div class="right menu">
                
                <?php   
                    if (Yii::$app->user->isSuperadmin)
                        echo SemanticGhostDropdown::widget([
                            'label' => 'Administrar',
                            'icon' => 'dropdown',
                            'addClass' => 'item',
                            'items' => SemanticGhostDropdown::authMenuItems()
                        ]);
                ?>

                <?php if (Yii::$app->user->isGuest) {    ?>
                    <div class="item">
                        <button class="compact ui right labeled icon primary button" onclick="window.location=
                        '<?= Url::to(['/user-management/auth/login']) ?>'">
                            <i class="user icon"></i>
                            Iniciar sesión
                        </button>
                    </div>
                <?php } else { ?>
                    <div class="item">
                        <button class="compact ui icon primary link button" onclick="window.location= '<?= Url::to(["settings"]) ?>' ">
                            <i class= " settings icon"></i>
                        </button>
                    </div>
                    <div class="item">                        
                        <?= Html::beginForm(['user-management/auth/logout']) . 
                            Html::submitButton('Cerrar sesión', ['class' => 'compact ui text gray link button']) . 
                            Html::endForm() ?>
                    </div>
                <?php } ?>
                <div class="item">
                    <button class="compact ui icon button" onclick="window.location= 'https://9gag.com/'">
                        <i class="help icon"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="pusher">
        <main>
            <?= $content ?>
        </main>
    </div>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>