<?php
namespace frontend\widgets\tag;
/**
 * 热门浏览组件
 */
use Yii;
use yii\bootstrap\Widget;
use yii\base\Object;
use frontend\models\Postextends;
use frontend\models\Posts;
use yii\db\Query;
use frontend\models\Tags;

class TagWidget extends Widget
{
    public $title = '';
    
    public $limit = 20;
    
    public function run()
    {
        $res = Tags::find()
            ->orderBy(['post_num'=>SORT_DESC])
            ->limit($this->limit)
            ->all();
        
        $result['title'] = $this->title?:'标签云';
        $result['body'] = $res?:[];
        
        return $this->render('index',['data'=>$result]);
    }
  
    
}