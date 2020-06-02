<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\EtiquetaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Etiquetas';
?>

<?php Pjax::begin(); ?>

<div class="ui one-form container">

    <div class="ui raised large card">
        <div class="content">
            <div class="fluid container">
                <div class="header"><?= Html::encode($this->title) ?></div>
                <div class="right floated"><?= Html::a('Crear etiqueta', ['create'], ['class' => 'ui green button']) ?>
                </div>
            </div>
            <div class="description">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'nombre:html',
                        'activo:boolean',
                        [
                            'class'     => 'app\components\SemanticActionColumn',
                            'template'  => '{view} {update}'
                        ],
                    ],
                    'tableOptions' => [
                        'class' => "ui table form"
                    ]
                ]); ?>
            </div>
        </div>
    </div>

</div>

<?php Pjax::end(); ?>