<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "post_extends".
 *
 * @property integer $id
 * @property integer $post_id
 * @property integer $browser
 * @property integer $collect
 * @property integer $praise
 * @property integer $comment
 */
class Postextends extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_extends';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'browser', 'collect', 'praise', 'comment'], 'integer'],
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
            'browser' => 'Browser',
            'collect' => 'Collect',
            'praise' => 'Praise',
            'comment' => 'Comment',
        ];
    }
    /**
     * @inheritdoc  更新文章统计
     * @param $where 条件/文章id 格式 ['post_id' => $id ]
     * @param $field 字段名称
     * @param $num   记录数量
     */

    public function UpCounter($where, $field, $num){
        $counter = $this->findOne($where);
        //判断有没有当前记录，没有就添加
        if(!$counter){
            $this->setAttributes($where);
            $this->$field = $num;
            $this->save();

        }else{
            $countData[$field] = $num;
            $counter->updateCounters($countData); //自带方法，更新记录,自动累加
        }
    }
}
