<?php

namespace common\models;

use Yii;
use common\models\base\BaseModel;
/**
 * This is the model class for table "ad".
 *
 * @property integer $id
 * @property integer $ad_position
 * @property string $name
 * @property string $desc
 * @property integer $is_show
 * @property string $imageurl
 * @property string $linkurl
 * @property string $is_linkurl
 * @property integer $order
 */
class Ad extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ad';
    }

    public function getAdposition(){
        return $this->hasOne(AdPosition::className(),['id' => 'ad_position']);
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ad_position', 'is_show', 'order'], 'integer'],
            [['name', 'desc', 'imageurl', 'linkurl', 'is_linkurl'], 'string', 'max' => 255],
        ];
    }
    //获取摸个位置的广告列表
    public static function GetListAd($type,$order = ['order' => 'ASC']){
        $res = self::find()->where($type)->with('adposition')->orderBy($order)->asArray()->all();

        return self::GetallAd($res);
    }

    public static function GetallAd($data){
        
        $ad = array();
        if(!empty($data)){
            foreach ($data as $key => $value) {
                $ad[$key]['label'] = $value['name'];
                $ad[$key]['image_url'] = $value['imageurl'];
                $ad[$key]['url'] = $value['linkurl'];
                $ad[$key]['html'] = '';
                $ad[$key]['active'] = 'active';
            }
        }
        return $ad;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ad_position' => 'Ad Position',
            'name' => 'Name',
            'desc' => 'Desc',
            'is_show' => 'Is Show',
            'imageurl' => 'Imageurl',
            'linkurl' => 'Linkurl',
            'is_linkurl' => 'Is Linkurl',
            'order' => 'Order',
        ];
    }
}
