<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\Posts;

/**
 * Posts tags
 */
class TagsForm extends Model
{
    public $id;
    public $tags;




    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            ['tags', 'required'], 

            ['tags','each', 'rule'=> ['string']],

        ];
    }

    public function saveTags(){
        $ids = [];
        if(!is_array($this->tags)){
            $data[] = $this->tags;
            $this->tags = $data;
        }
        if(!empty($this->tags)){
            foreach ($this->tags as $key => $value) {
                # code...
                $ids[] = $this->_saveTag($value);
            }
        }

        return  $ids;
    }


    private function _saveTag($tag){
        $model = new Tags();

        $res = $model->find()->where(['tags_name' => $tag])->one();

        //没有标签的，新加
        if(!$res){
            $model->tags_name = $tag;
            $model->post_num = 1;
            if(!$model->save()){
                throw new \Exception(Yii::t('common','Tagscreateerror'));
            }

            return $model->id;
        }else{
            $res->updateCounters(['post_num' => 1]);//直接更新post_name字段的统计数量
        }

        return $res->id;
    }
   
}
