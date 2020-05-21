<?php

namespace app\models;

use Yii;
use webvimark\modules\UserManagement\models\User;

/**
 * This is the model class for table "publicacion".
 *
 * @property int $id
 * @property string $url
 * @property string $titulo
 * @property string $media
 * @property int $id_usuario
 * @property string $fecha_creacion
 * @property string|null $fecha_actualizacion
 *
 * @property Comentario[] $comentarios
 * @property Usuario $usuario
 * @property PuntajePublicacion[] $puntajePublicacions
 * @property RelPublicacionEtiqueta[] $relPublicacionEtiquetas
 */
class Publicacion extends \app\components\CustomActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'publicacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'url', 'titulo', 'media', 'id_usuario'], 'required'],
            [['id', 'id_usuario'], 'integer'],
            [['fecha_creacion', 'fecha_actualizacion'], 'safe'],
            [['url'], 'string', 'max' => 10],
            [['titulo', 'media'], 'string', 'max' => 255],
            [['url'], 'unique'],
            [['id'], 'unique'],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_usuario' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'URL',
            'titulo' => 'Título',
            'media' => 'Imagen/Video',
            'id_usuario' => 'Usuario',
            'fecha_creacion' => 'Fecha de creación',
            'fecha_actualizacion' => 'Fecha de actualización',
        ];
    }

    /**
     * Gets query for [[Comentarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentario::className(), ['id_publicacion' => 'id']);
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
     * Gets query for [[PuntajePublicacions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPuntajePublicacions()
    {
        return $this->hasMany(PuntajePublicacion::className(), ['id_publicacion' => 'id']);
    }

    /**
     * Gets query for [[RelPublicacionEtiquetas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRelPublicacionEtiquetas()
    {
        return $this->hasMany(RelPublicacionEtiqueta::className(), ['id_publicacion' => 'id']);
    }
}
