<?php

namespace common\models;

use Yii;
use common\models\Ad;
/**
 * This is the model class for table "ad_position".
 *
 * @property integer $id
 * @property integer $width
 * @property integer $heigth
 * @property string $name
 * @property string $desc
 */
class AdPosition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ad_position';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['width', 'heigth'], 'integer'],
            [['name', 'desc'], 'string', 'max' => 255],
        ];
    }

    public function getAds(){
        return $this->hasMany(Ad::className(),['id' => 'ad_position']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'width' => 'Width',
            'heigth' => 'Heigth',
            'name' => 'Name',
            'desc' => 'Desc',
        ];
    }

    public static function GetallCats(){
        
        $cat = array();
        $res = self::find()->asArray()->all();
        //print_r($cat);die;
        if(!empty($res)){
            foreach ($res as $key => $value) {
                $cat[$value['id']] = $value['name'];
            }
        }else{
           $cat = ['0' => Yii::t('common','catekong')]; 
        }
        //print_r($cat);die;
        return $cat;
    }
}
