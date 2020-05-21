<?php

namespace app\models;

use Yii;
use webvimark\modules\UserManagement\models\User;

/**
 * This is the model class for table "pais".
 *
 * @property int $id
 * @property string $code
 * @property string $nombre
 * @property string $fecha_creacion
 * @property string|null $fecha_actualizacion
 *
 * @property Usuario[] $usuarios
 */
class Pais extends \app\components\CustomActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pais';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'code', 'nombre'], 'required'],
            [['id'], 'integer'],
            [['fecha_creacion', 'fecha_actualizacion'], 'safe'],
            [['code'], 'string', 'max' => 2],
            [['nombre'], 'string', 'max' => 255],
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
            'code' => 'Código',
            'nombre' => 'Nombre',
            'fecha_creacion' => 'Fecha de creación',
            'fecha_actualizacion' => 'Fecha de actualización',
        ];
    }

    /**
     * Gets query for [[Usuarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(User::className(), ['id_pais' => 'id']);
    }
}
