<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "cats".
 *
 * @property integer $id
 * @property string $catname
 */
class Cats extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cats';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['catname'], 'required'],
            //[['id'], 'integer'],
            [['catname'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'catname' => Yii::t('common','Catname'),
        ];
    }

    public static function GetallCats(){
        
        $cat = array();
        $res = self::find()->asArray()->all();
        //print_r($cat);die;
        if(!empty($res)){
            foreach ($res as $key => $value) {
                $cat[$value['id']] = $value['catname'];
            }
        }else{
           $cat = ['0' => Yii::t('common','catekong')]; 
        }
        //print_r($cat);die;
        return $cat;
    }
}
