<?php

namespace app\models;

use Yii;
use app\components\Utilidades;
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
 * @property int $nsfw
 *
 * @property Comentario[] $comentarios
 * @property Usuario $usuario
 * @property PuntajePublicacion[] $puntajePublicacions
 * @property RelPublicacionEtiqueta[] $relPublicacionEtiquetas
 */
class Publicacion extends \app\components\CustomActiveRecord
{
    public $media_file, $poster, $poster_avatar, $es_video, $comentarios, $puntuacion, $etiquetas, $me_gusta;

	public const MEDIA_BASE_PATH = 'media/posts/';

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
            [['url', 'titulo', 'media', 'id_usuario', 'nsfw', 'media_file'], 'required'],
            ['id_usuario', 'integer'],
            ['nsfw', 'boolean'],
            [['fecha_creacion', 'fecha_actualizacion'], 'safe'],
            [['url'], 'string', 'max' => 10],
            [['titulo', 'media'], 'string', 'max' => 255],
            ['titulo', 'trim'],
            [['url'], 'unique'],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_usuario' => 'id']],
            ['media_file', 'file','extensions' => 'png, jpg, jpeg, gif, mp4, avi, webm', 'skipOnError' => true],
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
            'relPublicacionEtiquetas' => 'Etiquetas',
            'nsfw' => 'Marcar publicación como NSFW (Not Safe For Work)'
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

    public static function mediaExists($key)
    {
		return glob(self::MEDIA_BASE_PATH . $key .".*")[0];
    }

    public static function generarURL() 
    {
        $url = "";

        do {
            $url = Utilidades::generateRandomString();
        }
        while(self::urlExists($url));

        return $url;
    }

    private static function urlExists($url) 
    {
        return Publicacion::findOne(["url" => $url]) != null;
    }

    public function generarEtiquetas() 
    {

        $etiquetas = "";

        foreach ($this->relPublicacionEtiquetas as $relation) {
            $etiqueta = $relation->etiqueta;

            if($etiqueta->activo)
                $etiquetas .= "," . $etiqueta->nombre;
        }

        return $etiquetas;
    }

    public function getFriendlyDate() 
    {
        return Utilidades::friendlyDate($this->fecha_creacion);
    }

    public function getLike() 
    {
        return intval(intval($this->me_gusta) === 1);
    }
    
    public function getDislike() 
    {
        return intval(intval($this->me_gusta) === -1);
    }
    
}
