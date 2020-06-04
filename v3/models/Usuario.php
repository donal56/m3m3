<?php

namespace app\models;

use Yii;
use yii\helpers\Html;
use webvimark\modules\UserManagement\UserManagementModule;
use webvimark\modules\UserManagement\models\UserVisitLog;
use webvimark\modules\UserManagement\models\rbacDB\Permission;
use webvimark\modules\UserManagement\models\rbacDB\Role;

/**
 * This is the model class for table "usuario".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $confirmation_token
 * @property int $status
 * @property int|null $superadmin
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $registration_ip
 * @property string|null $bind_to_ip
 * @property string|null $email
 * @property int $email_confirmed
 * @property string|null $password_reset_token
 * @property string|null $verification_token
 * @property string $nombre
 * @property string|null $fecha_nacimiento
 * @property string $avatar
 * @property int|null $id_pais
 * @property int $nsfw
 * @property int|null $sexo
 *
 * @property Asignacion[] $asignacions
 * @property Permiso[] $itemNames
 * @property Comentario[] $comentarios
 * @property Publicacion[] $publicacions
 * @property PuntajeComentario[] $puntajeComentarios
 * @property PuntajePublicacion[] $puntajePublicacions
 * @property Pais $pais
 * @property Visita[] $visitas
 */
class Usuario extends \webvimark\modules\UserManagement\models\User
{
	public $avatar_file;

	public const AVATAR_BASE_PATH = 'media/avatars/';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'email'], 'required'],
            
            [['password_hash', 'confirmation_token', 'bind_to_ip', 'password_reset_token', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['nombre'], 'string', 'max' => 45],
            ['username', 'string', 'max' => 50],
            
            [['fecha_nacimiento'], 'safe'],
            
            ['username', 'required'],
			['username', 'unique'],
            ['username', 'trim'],
            ['username', 'match', 'pattern'=>Yii::$app->getModule('user-management')->registrationRegexp],
            ['username', 'match', 'not'=>true, 'pattern'=>Yii::$app->getModule('user-management')->registrationBlackRegexp],
            
			['username', 'unique',
                'targetClass'     => 'webvimark\modules\UserManagement\models\User',
                'targetAttribute' => 'username',
            ],
            
            [['status', 'superadmin', 'created_at', 'updated_at', 'email_confirmed', 'id_pais', 'nsfw'], 'integer'],

            ['sexo', 'boolean', 'trueValue' => 'true', 'falseValue' => 'false', 'skipOnEmpty' => true],
            
			['email', 'email'],
			['email', 'validateEmailConfirmedUnique'],
            [['email'], 'string', 'max' => 128],
            ['email', 'unique',
                'targetClass'     => 'webvimark\modules\UserManagement\models\User',
                'targetAttribute' => 'email',
            ],

			['bind_to_ip', 'validateBindToIp'],
			['bind_to_ip', 'trim'],
			['bind_to_ip', 'string', 'max' => 255],
            
            [['registration_ip'], 'string', 'max' => 15],

			['password', 'required', 'on'=>['newUser', 'changePassword', 'registration']],
			['password', 'string', 'max' => 255, 'on'=>['newUser', 'changePassword', 'registration']],
			['password', 'trim', 'on'=>['newUser', 'changePassword', 'registration']],
			['password', 'match', 'pattern' => Yii::$app->getModule('user-management')->passwordRegexp],
            
			['repeat_password', 'required', 'on'=>['newUser', 'changePassword', 'registration']],
            ['repeat_password', 'compare', 'compareAttribute'=>'password'],
            
            [['avatar'], 'string', 'max' => 30],
            ['avatar_file', 'file','extensions' => 'png, jpg, jpeg', 'skipOnError' => true],
            [['avatar'], 'unique',
                'targetClass'     => 'app\models\Usuario',
                'targetAttribute' => 'avatar'
            ],

            [['id_pais'], 'exist', 'skipOnError' => true, 'targetClass' => Pais::className(), 'targetAttribute' => ['id_pais' => 'id']],

            ['avatar_file', 'required', 'on' => 'registration'],
			['repeat_password', 'trim', 'on' => 'registration'],
			['username', 'purgeXSS', 'on' => 'registration'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                 => 'ID',
			'username'           => UserManagementModule::t('back', 'Login'),
			'superadmin'         => UserManagementModule::t('back', 'Superadmin'),
			'confirmation_token' => UserManagementModule::t('back', 'Confirmation Token'),
			'registration_ip'    => UserManagementModule::t('back', 'Registration IP'),
			'bind_to_ip'         => UserManagementModule::t('back', 'Bind to IP'),
			'status'             => UserManagementModule::t('back', 'Status'),
			'gridRoleSearch'     => UserManagementModule::t('back', 'Roles'),
			'created_at'         => UserManagementModule::t('back', 'Created'),
			'updated_at'         => UserManagementModule::t('back', 'Updated'),
			'password'           => UserManagementModule::t('back', 'Password'),
			'repeat_password'    => UserManagementModule::t('back', 'Repeat password'),
			'email_confirmed'    => UserManagementModule::t('back', 'E-mail confirmed'),
            'email'              => UserManagementModule::t('back', 'E-mail'),

            'captcha'          => UserManagementModule::t('front', 'Captcha'),

            'nombre'             => 'Nombre completo',
            'fecha_nacimiento'   => 'Fecha de nacimiento',
            'avatar'             => 'Avatar',
            'id_pais'            => 'País',
            'nsfw'               => 'Ver contenido NSFW',
            'sexo'               => 'Sexo',
        ];
    }

    /**
	 * Remove possible XSS stuff
	 *
	 * @param $attribute
	 */
	public function purgeXSS($attribute)
	{
		$this->$attribute = Html::encode($this->$attribute);
	}

    /**
     * Gets query for [[Asignacions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAsignacions()
    {
        return $this->hasMany(Role::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[ItemNames]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItemNames()
    {
        return $this->hasMany(Permission::className(), ['name' => 'item_name'])->viaTable('asignacion', ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Comentarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentario::className(), ['id_usuario' => 'id']);
    }

    /**
     * Gets query for [[Publicacions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPublicacions()
    {
        return $this->hasMany(Publicacion::className(), ['id_usuario' => 'id']);
    }

    /**
     * Gets query for [[PuntajeComentarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPuntajeComentarios()
    {
        return $this->hasMany(PuntajeComentario::className(), ['id_usuario' => 'id']);
    }

    /**
     * Gets query for [[PuntajePublicacions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPuntajePublicacions()
    {
        return $this->hasMany(PuntajePublicacion::className(), ['id_usuario' => 'id']);
    }

    /**
     * Gets query for [[Pais]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPais()
    {
        return $this->hasOne(Pais::className(), ['id' => 'id_pais']);
    }

    /**
     * Gets query for [[Visitas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVisitas()
    {
        return $this->hasMany(UserVisitLog::className(), ['user_id' => 'id']);
    }

    public function avatarExists() {
		return glob(self::AVATAR_BASE_PATH . $this->username .".*")[0];
    }

    public static function adminMenuOptions() 
    {
        return [
            [
                'icon' => 'tags',
                'label' => 'Etiquetas', 
                'url' => ['/etiqueta'],
            ],
            [   
                'icon' => 'users',
                'label' => UserManagementModule::t('back', 'Users'), 
                'url' => ['/user-management/user/index'],
            ],
            [   
                'icon' => 'shield alternate',
                'label' => UserManagementModule::t('back', 'Roles'), 
                'url' => ['/user-management/role/index'],
            ],
            [   
                'icon' => 'check',
                'label' => UserManagementModule::t('back', 'Permissions'), 
                'url' => ['/user-management/permission/index'],
            ],
            [
                'icon' => 'check circle',
                'label' => UserManagementModule::t('back', 'Permission groups'), 
                'url' => ['/user-management/auth-item-group/index'],
            ],
            [
                'icon' => 'clipboard list',
                'label' => UserManagementModule::t('back', 'Visit log'), 
                'url' => ['/user-management/user-visit-log/index'],
            ],
        ];
    }
}
