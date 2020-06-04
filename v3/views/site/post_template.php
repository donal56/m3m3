<?php

    use yii\helpers\Url;
    use yii\helpers\Html;
    use yii\web\JsExpression;
    use app\components\SemanticActiveForm;

?>

<article style="display: none;" data-id= "<?= $model->url ?>">
    <div class="ui fluid raised card">
        <div class="content">
            <div class="ui left floated">
                <a href="#"><img class="ui custom avatar image" src="<?= $model->poster_avatar ?>" onclick=""> <b>
                        <?= Html::encode($model->poster) ?></a></b>
            </div>
            <div class="right floated meta"><?= $model->getFriendlyDate() ?></div>
        </div>
        <div class="content post-title">
            <div class="header"><?= Html::encode($model->titulo) ?></div>
        </div>
        <a class="image" href="<?= Url::to(["site/comments", "p" => $model->url]) ?>">
            <?php if ($model->es_video) { ?>
                <video src="<?= $model->media ?>" controls>
                <?php } else { ?>
                    <img src="<?= $model->media ?>" alt="">
                <?php } ?>
        </a>
        <div class="content">
            <span class="left floated comments-section">
                <i class="comments outline icon"></i>
                <?= $model->comentarios ?> comentarios
            </span>
            <span class="right floated likes-section">
                <?php if($model->puntuacion >= 0) {?>
                    <i class="thumbs up outline icon"></i>
                <?php } else { ?>
                        <i class="thumbs down outline icon"></i>
                <?php } ?>
                <?= $model->puntuacion ?> me gusta
            </span>
        </div>
        <div class="extra content">
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
            <div class="ui fluid container comment-section">
                <img class="ui left floated item avatar image" src="<?= Yii::$app->user->identity ? Yii::$app->user->identity->avatar : '/media/pp.png' ?>">
                <?php $form = SemanticActiveForm::begin([
                        "script" => false,
                        "action" => Url::to("/comentario/new"),
                        "options" => [
                            "onsubmit"  =>  new JsExpression("return comentar(event, this)"),
                            "class"     =>  "ui item unstackable form",
                        ]]) 
                ?>
                    <div class="inline fields">
                        <?= $form->field($modelCom, 'texto', ["options" => ['class' => 'twelve wide field']])
                                ->textInput([
                                    "max-length" => 255, 
                                    "required" => "required",
                                    "class" => "comment-box", 
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
        </div>
    </div>
</article>