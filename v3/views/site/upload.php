<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use app\models\Etiqueta;
use app\components\SemanticActiveForm;

$color= "green";

?>

<div class="ui one-form container">
    <div class="ui raised <?=$color?> medium card">
        <div class="content">
            <div class="fluid container">
                <img class="left floated avatar" src= "<?= Yii::$app->user->identity->avatar ?>">
                <div class="header">Subir publicación</div>
            </div>
            <div class="description">
                <?php $form = SemanticActiveForm::begin(["ajax" => [ "class" => "indicating small $color", "redirect" => Url::home() ]]) ?>
                    <?= $form->field($model, 'titulo')->textarea(["rows" => 2, "info" => "Max. 255 carácteres"]) ?>
                    <?= $form->field($model, 'media')->fileInput(false, ["accept" => ".png,.jpg,.jpeg,.gif,.mp4,.avi,.webm"]) ?>
                    <?= $form->field($model, "relPublicacionEtiquetas")->listBox(Etiqueta::getList(), ['multiple' => true, "size" => 6]) ?>
                    <?= $form->field($model, "nsfw")->toogle() ?>
                    <?= $form->submitButton('Publicar', null, ['class' => "ui $color fluid button"]) ?>
                    <?= $form->errorBox() ?>    
                 <?php SemanticActiveForm::end() ?>
            </div>
        </div>
    </div>
</div>