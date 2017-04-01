<?php

namespace common\models;

use Yii;
use common\models\base\BaseModel;
/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 */
class Posts extends BaseModel
{
    const IS_VALID = 1;//发布
    const NO_VALID = 0; //未发布
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    public function getRelate(){
        return $this->hasMany(RelationPostTags::className(),['post_id' => 'id']);
    }

    public function getExtend(){
        return $this->hasOne(Postextends::className(),['post_id' => 'id']);
    }

    public function getCats(){
        return $this->hasOne(Cats::className(),['cat_id' => 'id']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','is_valid','cat_id'], 'required'],
            [['id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    // public function attributeLabels()
    // {
    //     return [
    //         //'id' => 'ID',
    //     ];
    // }

    public function attributeLabels(){
        return [
            //'id' => Yii::t('common','ID'),
            'title' => Yii::t('common','title'),
            'content' => Yii::t('common','content'),
            'label_img' => Yii::t('common','label_img'),
            'tags' => Yii::t('common','tags'),
            'cat_id' =>Yii::t('common','cat_id'),
        ];
    }

    /**
     * @ 文章的创建
     */
    public function create(){

    }
}
