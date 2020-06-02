<?php

/* @var $this yii\web\View */

    use yii\web\View;

    $this->registerJsFile("js/post.js", ['position' => $this::POS_END]);
    $this->registerCssFile("css/feed.css");

    $script = <<<JS

        $('main').visibility({
            once: false,
            continuous: true,
            initialCheck: false,
            onPassed: {
                '50%': () => { feed() }
            }
        });
JS;

    $this->registerJs($script, View::POS_READY);
?>
<navbar>
    <ul>
        <li data-type="popular" class="selected"><a href="#">Popular</a></li>
        <li data-type="tendencia"><a href="#">Tendencia</a></li>
        <li data-type="nuevo"><a href="#">Nuevo</a></li>
    </ul>
</navbar>


