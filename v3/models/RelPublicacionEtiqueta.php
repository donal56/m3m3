<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rel_publicacion_etiqueta".
 *
 * @property int $id
 * @property int $id_publicacion
 * @property int $id_etiqueta
 *
 * @property Publicacion $publicacion
 * @property Etiqueta $etiqueta
 */
class RelPublicacionEtiqueta extends \app\components\CustomActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rel_publicacion_etiqueta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_publicacion', 'id_etiqueta'], 'required'],
            [['id', 'id_publicacion', 'id_etiqueta'], 'integer'],
            [['id'], 'unique'],
            [['id_publicacion'], 'exist', 'skipOnError' => true, 'targetClass' => Publicacion::className(), 'targetAttribute' => ['id_publicacion' => 'id']],
            [['id_etiqueta'], 'exist', 'skipOnError' => true, 'targetClass' => Etiqueta::className(), 'targetAttribute' => ['id_etiqueta' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_publicacion' => 'Publicación',
            'id_etiqueta' => 'Etiqueta',
        ];
    }

    /**
     * Gets query for [[Publicacion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPublicacion()
    {
        return $this->hasOne(Publicacion::className(), ['id' => 'id_publicacion']);
    }

    /**
     * Gets query for [[Etiqueta]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEtiqueta()
    {
        return $this->hasOne(Etiqueta::className(), ['id' => 'id_etiqueta']);
    }
}
