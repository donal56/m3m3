<?php

use app\components\SemanticActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Etiqueta */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ui one-form container">
    <div class="ui raised medium card">
        <div class="content">
            <div class="fluid container">
                <div class="header"><?= $this->title ?></div>
            </div>
            <div class="description">
                <?php $form =  SemanticActiveForm::begin(); ?>
                
                <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>
                
                <?= $form->field($model, "activo")->toogle(["checked" => ($model->isNewRecord ? "checked" : null) ]) ?>
                
                <?= $form->submitButton('Publicar', null, ['class' => "ui $color fluid button"]) ?>
                <?= $form->errorBox() ?> 
                
                <?php SemanticActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
