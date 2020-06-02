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
            [['nombre', 'icon'], 'required'],
            [['activo'], 'integer'],
            [['nombre'], 'string', 'max' => 100],
            [['icon'], 'string', 'max' => 30],
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
            'icon'  =>  'Ícono'
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

        $etiquetas = self::findAllActives();

        $list = [];

        foreach ($etiquetas as $etiqueta) {
            $list[$etiqueta->id] = $etiqueta->nombre;
        }
        return $list;
    }

    public static function findAllActives() {

        return self::find()->where(["activo" => 1])->orderBy(["nombre" => "ASC"])->all();
    }
}
