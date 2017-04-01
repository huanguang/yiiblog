<?php
namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\Helpers\ArrayHelper;
use common\models\Region;
use yii\base\Model;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class Admin extends ActiveRecord implements IdentityInterface
{
    public $password;
    public $new_password;
    public $new_passwords;
    public $_lastError = '';
    public $district;
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const EVENT_AFTER_UPDATE = 'eventAfterUpdate';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            [['email', 'avatar', 'address', 'iphone', 'area', 'city', 'province'], 'required'],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    public function attributeLabels(){
        return [
            //'id' => Yii::t('common','ID'),
            'new_passwords' => '确认新密码',
            'new_password' => '新密码',
            'status' => '状态',
            'password' => '旧密码',
            'email' => '邮箱',
            'username' => '用户名',
            'iphone' => '手机号码',
            'address' => '地址',
            'avatar' => '头像',
            'province' => '省',
            'city' => '市',
            'area' => '区',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @param $pid
     * @return array
     */
    public function getCityList($pid)
    {
        $model = Region::findAll(array('parent_id'=>$pid));
        return ArrayHelper::map($model, 'id', 'name');
    }
    //修改用户密码
    public function changePassword($data){
        $id = Yii::$app->user->id;
        $admin = YiiUser::findOne($id);
        $password = $admin->password_hash;
        if(Yii::$app->getSecurity()->validatePassword($data['password'], $password)){
            if($data['passwords'] == $data['passwords_repeat']){
                $newPass = Yii::$app->getSecurity()->generatePasswordHash($data['passwords']);
                $admin->password_hash = $newPass;
                if($admin->save()){
                    Yii::$app->session->setFlash('success','密码修改成功，下次登录请使用新密码登录!');
                    return true;
                }else{
                    Yii::$app->session->setFlash('error','服务器错误，请稍后重试！');
                    return false;
                }
            }else{
                Yii::$app->session->setFlash('error','两次新密码不一致！');
                return false;
            }
        }else{
            Yii::$app->session->setFlash('error','旧密码错误！');
            return false;
        }
    }

    //更新用户地址信息
    public function RegionUpdate($data){
        $id = Yii::$app->user->id;
        $admin = Admin::findOne($id);
        $city = Region::find()->where(['id' => $data['city']])->asArray()->one();
        $area = Region::find()->where(['id' => $data['area']])->asArray()->one();
        $province = Region::find()->where(['id' => $data['province']])->asArray()->one();
        $admin->addres = $province['name'].$city['name'].$area['name'];
        
        $admin->save();

        return true;

    }


    public function updatepassword($data){
        $transaction = Yii::$app->db->beginTransaction();

            try{
                //echo 23423;die;
                $model = new Admin();
                $model->_eventAfterUpdate($data);
                //echo 23423;die;
                return true;
            }catch (\Exception $e){
                //$transaction->rollBack();

                $this->_lastError = $e->getMessage();
                return false;
            }
    }

    /**
     * 账户信息修改后的事件
     *
     * @param array $data 
     * @return $value|null _getArticleDesc
     */
    public function _eventAfterUpdate($data){
        $this->on(self::EVENT_AFTER_UPDATE, [$this,'_eventUpdatePassword'], $data); //添加事件
        
        //触发事件
        $this->trigger(self::EVENT_AFTER_UPDATE);
        return true;
    }
    /**
     * 修改密码
     *
     * @param 
     * @return $value|null _getArticleDesc
     */

    public function _eventUpdatePassword($event){

        $id = Yii::$app->user->id;
        $admin = Admin::findOne($id);
        $password = $admin->password_hash;
        $data = $event->data;
        //print_r($data);die;
        if(Yii::$app->getSecurity()->validatePassword($data['password'], $password)){
            if($data['new_passwords'] == $data['new_password']){
                $newPass = Yii::$app->getSecurity()->generatePasswordHash($data['new_password']);
                $admin->password_hash = $newPass;
                if($admin->save()){
                    throw new \Exception('密码修改成功，下次登录请使用新密码登录!');
                }else{

                    throw new \Exception('密码修改失败，请稍后重试！');
                }
            }else{

                throw new \Exception('密码修改失败：两次新密码不一致！');
            }
        }else{

            throw new \Exception('密码修改失败：旧密码错误！');
        }
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
