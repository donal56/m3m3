<?php
    use yii\helpers\Url;
    use yii\helpers\Html;
    use yii\web\JsExpression;
    use app\components\SemanticActiveForm;

    $this->registerJsFile("/js/post.js", ['position' => $this::POS_END]);
    $this->registerCssFile("/css/comments.css");

    $this->registerJs("loadComments('$model->url')", $this::POS_READY);
?>

<div class="ui one-form container">
    <div class="ui raised blue extra large contained card">
        <div class="content">
            <div class="ui left floated">
                <a href="#"><img class="ui custom avatar image" src="<?= $model->poster_avatar ?>" onclick=""> <b>
                    <?= Html::encode($model->poster) ?></a></b>
            </div>
            <div class="right floated meta"><?= $model->getFriendlyDate() ?></div>
        </div>
        <div class="content post-title">
            <div class="header"><h1><?= Html::encode($model->titulo) ?></h1></div>
        </div>
        <div class="ui stackable grid" data-id= "<?= $model->url ?>">
            <div class="nine wide column">
                <?php if ($model->es_video) { ?>
                    <video class= "media" src="<?= $model->media ?>" controls>
                <?php } else { ?>
                    <img class="ui image media" src="<?= $model->media ?>" alt="">
                <?php } ?>
                <div class="post-info">
                <span class= "likes-section"><?= $model->puntuacion ?> me gusta</span> • <span class= "comments-section"><?= $model->comentarios ?> comentarios</span>
                    <div class="ui fluid five item grid container secondary compact text options-section menu">
                        <div class="item like-button" onclick="postAction('like', this, '.dislike-button');" data-state="<?= $model->like ?>">
                            <i class="thumbs up icon" <?= $model->like ? 'style = "color: black;"' : ''?>></i>
                        </div>
                        <div class="item dislike-button" onclick="postAction('dislike', this, '.like-button');" data-state="<?= $model->dislike ?>">
                            <i class="thumbs down icon" <?= $model->dislike ? 'style = "color: black;"' : ''?>></i>
                        </div>
                        <div class="item comment-button" onclick="window.location= '<?= Url::to(["site/comments", "p" => $model->url]) ?>'">
                            <i class="comments icon"></i>
                        </div>
                        <div class="item facebook-button" onclick="window.open('https://www.facebook.com/sharer.php?t=Checa esto!&u=<?= Url::to(["site/comments", "p" => $model->url], true) ?>')">
                            <i class="facebook icon"></i>
                        </div>
                        <div class="item twitter-button" onclick="window.open('https://twitter.com/intent/tweet?text=Checa esto!&url=<?= Url::to(["site/comments", "p" => $model->url], true) ?>')">
                            <i class="twitter icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="seven wide column">
                <div class="ui fluid container">
                    <img class="ui left floated item avatar image" src="<?= Yii::$app->user->identity ? Yii::$app->user->identity->avatar : '/media/pp.png' ?>">
                    <?php $form = SemanticActiveForm::begin([
                            "script" => false,
                            "action" => Url::to("/comentario/new"),
                            "options" => [
                                "onsubmit"  =>  new JsExpression("return comentar(event, this, '$model->url')"),
                                "class"     =>  "ui item unstackable form",
                            ]]) 
                    ?>
                        <div class="inline fields">
                            <?= $form->field($modelCom, 'texto', ["options" => ['class' => 'ten wide field']])
                                    ->textarea([
                                        "max-length" => 255,
                                        "rows" => 1,
                                        "required" => "required",
                                        "placeholder" => "Comenta algo gracioso..."])
                                    ->label(false); 
                            ?>
                            <?= $form->field($modelCom, 'media')->fileInput(false, ["accept" => ".png,.jpg,.jpeg,.gif",
                                    "style" => "display: block; visibility: hidden; width: 0; height: 0; padding: 0; border: 0;"])
                                    ->label("<i class= 'camera icon'></i>", ["class" => "ui blue button", "style" => "color: white; padding: 11.5px 21px;"])?>
                            <?= $form->submitButton(null, "send", ['class' => "ui green button"]) ?>
                        </div>
                    <?php SemanticActiveForm::end() ?>
                </div>
                <div class="ui comments">
                    
                </div>
            </div>
        </div>
    </div>
</div>