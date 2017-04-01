<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tags".
 *
 * @property integer $id
 * @property string $tags_name
 * @property integer $post_num
 */
class Tags extends \yii\db\ActiveRecord
{
    const SORT_DESC = 'desc';
    const SORT_ASC = 'asc';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_num'], 'integer'],
            [['tags_name'], 'string', 'max' => 255],
        ];
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tags_name' => Yii::t('common','Tags Name'),
            'post_num' => Yii::t('common','Post Num'),
        ];
    }
}
