<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "relation_post_tags".
 *
 * @property integer $id
 * @property integer $post_id
 * @property integer $tags_id
 */
class RelationPostTags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'relation_post_tags';
    }

    public function getTag(){
        return $this->hasOne(Tags::className(),['id' => 'tags_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'tags_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'tags_id' => 'Tags ID',
        ];
    }



    public static function GetallTags($id){
        $tag = [];
        $res = self::find()->with('tag')->where(['post_id' => $id])->asArray()->all();
        if($res){
            foreach ($res as $key => $value) {
                $tag[] = $value['tag']['tags_name'];
            }
        }

        return $tag ? $tag : [];

    }


}
