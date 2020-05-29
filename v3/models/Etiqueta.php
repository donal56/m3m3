<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "etiqueta".
 *
 * @property int $id
 * @property string $nombre
 * @property int $activo
 *
 * @property RelPublicacionEtiqueta[] $relPublicacionEtiquetas
 */
class Etiqueta extends \app\components\CustomActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'etiqueta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nombre'], 'required'],
            [['id', 'activo'], 'integer'],
            [['nombre'], 'string', 'max' => 100],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'activo' => 'Estatus',
        ];
    }

    /**
     * Gets query for [[RelPublicacionEtiquetas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRelPublicacionEtiquetas()
    {
        return $this->hasMany(RelPublicacionEtiqueta::className(), ['id_etiqueta' => 'id']);
    }

    public static function getList() {

        $etiquetas = self::find()->all();

        $list = [];

        foreach ($etiquetas as $etiqueta) {
            $list[$etiqueta->id] = $etiqueta->nombre;
        }
        return $list;
    }
}
