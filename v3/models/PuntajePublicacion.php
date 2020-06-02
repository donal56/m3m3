<?php

namespace app\models;

use Yii;
use webvimark\modules\UserManagement\models\User;

/**
 * This is the model class for table "puntaje_publicacion".
 *
 * @property int $id
 * @property int|null $puntaje
 * @property int $id_usuario
 * @property int $id_publicacion
 *
 * @property Usuario $usuario
 * @property Publicacion $publicacion
 */
class PuntajePublicacion extends \app\components\CustomActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'puntaje_publicacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario', 'id_publicacion'], 'required'],
            [['puntaje', 'id_usuario', 'id_publicacion'], 'integer'],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_usuario' => 'id']],
            [['id_publicacion'], 'exist', 'skipOnError' => true, 'targetClass' => Publicacion::className(), 'targetAttribute' => ['id_publicacion' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'puntaje' => 'Puntaje',
            'id_usuario' => 'Usuario',
            'id_publicacion' => 'Publicación',
        ];
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(User::className(), ['id' => 'id_usuario']);
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
}
