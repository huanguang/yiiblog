<?php
namespace frontend\models;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $repassword;
    public $verifyCode;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('common','This username has already been taken.')],
            ['username', 'string', 'min' => 6, 'max' => 16],
            ['username', 'match', 'pattern'=>'/^[0-9a-zA-Z_\x{4e00}-\x{9fa5}]+$/u','message'=>Yii::t('common','Usermatch')],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('common','This email address has already been taken.')],

            [['password','repassword'], 'required'],
            [['password','repassword'], 'string', 'min' => 6],
            ['repassword','compare','compareAttribute' => 'password','message' => Yii::t('common','Two items the password is not consittent.')],//验证密码和重复密码的一致性

            ['verifyCode','captcha'] //验证码验证
        ];
    }


    public function attributeLabels(){
        return [
            'username' => Yii::t('common','username'),
            'email' => Yii::t('common','email'),
            'repassword' => Yii::t('common','repassword'),
            'password' => Yii::t('common','password'),
            'verifyCode' => Yii::t('common','verifyCode'),
            'Signup' => Yii::t('common','Signup'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
