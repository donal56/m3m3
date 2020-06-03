<?php
    use yii\helpers\Html;
?>

<div class="comment">
    <a class="avatar">
        <img src="<?= $model->poster_avatar ?>">
    </a>
    <div class="content">
        <a class="author" href="#"><?= Html::encode($model->poster) ?></a>
        <div class="metadata">
            <span class="date"><?= $model->getFriendlyDate() ?> </span>
        </div>
        <div class="text">
            <p><?= Html::encode($model->texto) ?></p>
        </div>
        <?php if ($model->es_video) { ?>
            <video class="rounded"  src="<?= $model->media ?>" controls>
        <?php } else { ?>
            <img class="ui rounded image" src="<?= $model->media ?>" onclick= "window.open('<?= $model->media ?>')">
        <?php } ?>
        <div class="actions">
            <span class= "likes-section"><a><?= $model->puntuacion ?>pts </a></span>
            <a class="like-button" onclick="postAction('like', this, '.dislike-button', <?= $model->id ?>);" data-state="<?= $model->like ?>">
                <i class="arrow up icon" style = "<?= $model->like ? 'color: black;' : ''?>"></i>
            </a>
            <a class="dislike-button" onclick="postAction('dislike', this, '.like-button', <?= $model->id ?>);" data-state="<?= $model->dislike ?>">
                <i class="arrow down icon" style = "<?= $model->dislike ? 'color: black;' : ''?>"></i>
            </a>
            <a href="#"><i class="ellipsis horizontal icon"></i></a>
        </div>
    </div>
</div>