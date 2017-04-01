<?php

namespace common\models;

use Yii;
use yii\Helpers\ArrayHelper;

/**
 * This is the model class for table "region".
 *
 * @property integer $region_id
 * @property integer $parent_id
 * @property string $region_name
 * @property integer $region_type
 * @property integer $agency_id
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'region_type', 'agency_id'], 'integer'],
            [['region_name'], 'string', 'max' => 120],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'region_id' => 'Region ID',
            'parent_id' => 'Parent ID',
            'region_name' => 'Region Name',
            'region_type' => 'Region Type',
            'agency_id' => 'Agency ID',
        ];
    }

    public static function getRegion($parentId=1)
    {
        $result = static::find()->where(['parent_id'=>$parentId])->asArray()->all();
        return ArrayHelper::map($result, 'id', 'name');
    }
    /**
     * @param $pid
     * @return array
     */
    public function getCityList($pid = 1)
    {
        $model = self::findAll(array('parent_id'=>$pid));
        return ArrayHelper::map($model, 'id', 'name');
    }
}
