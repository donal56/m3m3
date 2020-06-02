<?php
    use yii\helpers\Html;
    use yii\widgets\DetailView;

    /* @var $this yii\web\View */
    /* @var $model app\models\Etiqueta */

    $this->title = $model->nombre;
    \yii\web\YiiAsset::register($this);
?>
<div class="ui one-form container">
    <div class="ui raised large card">
        <div class="content">
            <div class="fluid container">
                <div class="header"><?= Html::encode($this->title) ?></div>
                <div class="right floated">
                    <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'ui green button']) ?>
                </div>
                <div class="right floated">
                    <?= Html::a('Volver', ['index'], ['class' => 'ui blue button']) ?>
                </div>
            </div>
            <div class="description">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'nombre:html',
                        'activo:boolean',
                    ],
                ]) ?>
            </div>
        </div>
    </div>

</div>
