<?php

/* @var $this yii\web\View */

use app\components\SemanticActiveForm;
use app\models\Pais;

$color= "blue";

?>

<div class="ui one-form container">
    <div class="ui raised <?=$color?> medium card">
        <div class="content">
            <div class="fluid container">
                <img class="left floated avatar" src="<?= Yii::$app->user->identity->avatar ?>">
                <div class="header">Configuración</div>
            </div>
            <div class="ui top attached tabular menu" style="padding-top: 10px">
                <a class="active item" data-tab="usuario">Cuenta</a>
                <a class="item" data-tab="persona">Datos personales</a>
                <?php if( Yii::$app->user->identity->hasPermission("changeOwnPassword") ) { ?>
                    <a class="item" data-tab="contraseña">Cambiar contraseña</a>
                <?php } ?>
            </div>
            <div class="ui bottom attached active tab segment" data-tab="usuario">
                <?php $form = SemanticActiveForm::begin(["ajax" => [ "class" => "indicating small $color" ]]) ?>
				    <?= $form->field($model, 'avatar')->fileInput(true, ["accept" => ".jpg,.jpeg,.png"]) ?>
                    <?= $form->field($model, 'email')->textInput(['type' => 'email', 'value' => '', 'placeholder' => $model->email]) ?>
                    <?= $form->field($model, 'nsfw')->toogle() ?>
                    <?= $form->submitButton('Guardar cambios', null, ['class' => "ui $color fluid button"]) ?>
                    <?= $form->errorBox() ?>    
                 <?php SemanticActiveForm::end() ?>
            </div>
            <div class="ui bottom attached tab segment" data-tab="persona">
                <?php $form2 = SemanticActiveForm::begin(["ajax" => [ "class" => "indicating small $color" ]]) ?>
                    <?= $form2->field($model, 'fecha_nacimiento')->textInput(['type' => 'date']) ?>
                    <?= $form2->field($model, "id_pais")->dropDownList(Pais::getList(), ['prompt'=>'--Seleccione un país--']) ?>
                    <?= $form2->field($model, 'sexo')->radioList([
                        "1" => "Masculino",
                        "0" => "Femenino",
                        "" => "Otro"
                    ]) ?>
                    <?= $form->submitButton('Guardar cambios', null, ['class' => "ui $color fluid button"]) ?>
                    <?= $form->errorBox() ?>  
                <?php SemanticActiveForm::end() ?>
            </div>
            <?php if( Yii::$app->user->identity->hasPermission("changeOwnPassword") ) { ?>
                <div class="ui bottom attached tab segment" data-tab="contraseña">
                    <?php $form3 = SemanticActiveForm::begin(["ajax" => [ "class" => "indicating small $color" ]]) ?>
                    <?= $form3->field($modelPassword, 'current_password')->textInput(['type' => 'password', 'autocomplete' => 'off']) ?>
                        <?= $form3->field($modelPassword, 'password')->textInput(['type' => 'password', 'autocomplete' => 'off']) ?>
                        <?= $form3->field($modelPassword, 'repeat_password')->textInput(['type' => 'password', 'autocomplete' => 'off']) ?>
                        <?= $form->submitButton('Guardar cambios', null, ['class' => "ui $color fluid button"]) ?>
                        <?= $form->errorBox() ?>  
                    <?php SemanticActiveForm::end() ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
