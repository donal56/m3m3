<?php

    use yii\helpers\Url;
    use yii\helpers\Html;
?>

<article style="display: none;" data-id= "<?= $model->url ?>">
    <div class="ui fluid raised card">
        <div class="content">
            <div class="ui left floated">
                <a href="#"><img class="ui custom avatar image" src="<?= $model->poster_avatar ?>" onclick=""> <b>
                        <?= $model->poster ?></a></b>
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
            <span class="left floated">
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
                    <i class="thumbs up icon" style = "<?= $model->like ? 'color: black;' : ''?>"></i>
                </div>
                <div class="item dislike-button" onclick="postAction('dislike', this, '.like-button');" data-state="<?= $model->dislike ?>">
                    <i class="thumbs down icon" style = "<?= $model->dislike ? 'color: black;' : ''?>"></i>
                </div>
                <div class="item comment-button" onclick="window.location= '<?= Url::to(["site/comments", "p" => $model->url]) ?>'">
                    <i class="comments icon"></i>
                </div>
                <div class="item facebook-button" onclick="window.open('https://www.facebook.com/sharer.php?t=Me reí&u=me.me')">
                    <i class="facebook icon"></i>
                </div>
                <div class="item twitter-button" onclick="window.open('https://twitter.com/intent/tweet?text=Me reí&url=http%3A%2F%2Fme.me')">
                    <i class="twitter icon"></i>
                </div>
            </div>
            <div class="ui fluid container comment-section">
                <img class="ui left floated item avatar image" src="<?= Yii::$app->user->identity->avatar ?>" onclick="">
                <form class="ui item unstackable form" onsubmit="return comentar(event, this)">
                    <div class="inline fields">
                        <div class="twelve wide field">
                            <input type="text" name="comentario" class="comment-box" placeholder="Comenta algo gracioso..." required maxlength="280">
                        </div>
                        <div class="field">
                            <button type="submit" class="ui green button">
                                <i class="send icon"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</article>