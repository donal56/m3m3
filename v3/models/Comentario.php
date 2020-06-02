<?php

namespace app\models;

use Yii;
use app\components\Utilidades;

use webvimark\modules\UserManagement\models\User;

/**
 * This is the model class for table "comentario".
 *
 * @property int $id
 * @property string|null $texto
 * @property string|null $media
 * @property int $id_usuario
 * @property int $id_publicacion
 * @property string $fecha_creacion
 * @property string|null $fecha_actualizacion
 *
 * @property Usuario $usuario
 * @property Publicacion $publicacion
 * @property PuntajeComentario[] $puntajeComentarios
 */
class Comentario extends \app\components\CustomActiveRecord
{
    public $media_file;

	public const MEDIA_BASE_PATH = 'media/posts/comments/';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comentario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario', 'id_publicacion', 'texto'], 'required'],
            [['id_usuario', 'id_publicacion'], 'integer'],
            [['fecha_creacion', 'fecha_actualizacion'], 'safe'],
            [['texto'], 'string', 'max' => 255],
            [['media'], 'string', 'max' => 50],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_usuario' => 'id']],
            [['id_publicacion'], 'exist', 'skipOnError' => true, 'targetClass' => Publicacion::className(), 'targetAttribute' => ['id_publicacion' => 'id']],
            ['media_file', 'file','extensions' => 'png, jpg, jpeg, gif', 'skipOnError' => true],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'texto' => 'Comentario',
            'media' => 'Imagen/Video',
            'id_usuario' => 'Usuario',
            'id_publicacion' => 'Publicación',
            'fecha_creacion' => 'Fecha de creación',
            'fecha_actualizacion' => 'Fecha de actualización',
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

    /**
     * Gets query for [[PuntajeComentarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPuntajeComentarios()
    {
        return $this->hasMany(PuntajeComentario::className(), ['id_comentario' => 'id']);
    }

    public static function mediaExists($key)
    {
		return glob(self::MEDIA_BASE_PATH . $key .".*")[0];
    }

    public static function generarMedia() 
    {
        $media = "";

        do {
            $media = Utilidades::generateRandomString(20);
        }
        while(self::mediaExists($media));

        return $media;
    }
}
