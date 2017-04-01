<?php
namespace common\models;

use Yii;
use yii\base\Model;
use common\models\Posts;
use frontend\models\TagsForm;
use frontend\models\RelationPostTags;
use yii\db\Query;
/**
 * Posts form
 */
class PostsForm extends Model
{
    public $id;
    public $title;
    public $content;
    public $label_img;
    public $tags = [];
    public $cat_id;
    public $_lastError = "";
    //设置应用场景常量。添加/更新
    const SCENARIOS_CREATE = 'create';
    const SCENARIOS_UPDATE = 'update';

    //设置事件常量. 添加/修改
    const EVENT_AFTER_CREATE = 'eventAfterCreate';
    const EVENT_AFTER_UPDATE = 'eventAfterUpdate';

    //const SORT_DESC = 'desc';
    //const SORT_ASC = 'asc';


    public function scenarios(){
         
        $scenariosa = [
            self::SCENARIOS_CREATE => ['title', 'content', 'label_img', 'tags', 'cat_id'],
            self::SCENARIOS_UPDATE => ['title', 'content', 'label_img', 'tags', 'cat_id'],
        ];

        return array_merge(parent::scenarios(),$scenariosa);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['title', 'content', 'cat_id'], 'required'], //标题。内容。分类是必须选择的

            ['cat_id','integer'],//分类id必须是数字

            ['title', 'string', 'min'=>4, 'max'=>50],//标题必须是字符串，并且长度只能是4到50之间
        ];
    }


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
     * 文章创建
     * 
     *
     * @param 
     * @param 
     */
    public function create(){
        //事务

        $transaction = Yii::$app->db->beginTransaction();
        try{
            $model = new Posts();
            //print_r(Yii::$app->user->identity->id);
            $model->setAttributes($this->attributes,false);//数据设置到$model里面 第二个参数设置表示不检测字段安全
            //print_r($this->title);

            $model->desc = $this->_getArticleDesc(); //文章简介
            $model->user_id = Yii::$app->user->identity->id; //会员id
            $model->username = Yii::$app->user->identity->username; //会员名
            $model->created_at = time();
            $model->updated_at = time();
            $model->is_valid = Posts::IS_VALID;
            $tags = $model->tags;

            $model->tags = count($tags);
            if(!$model->save())
                throw new \Exception(Yii::t('common','Postscreateerror'));

            $this->id = $model->id;//设置返回增加id
            //print_r($model->id);
            unset($model->tags);
            $model->tags = $tags;

            //调用事件
            $data = array_merge($this->getAttributes(),$model->getAttributes());
            //print_r($data);
            $this->_eventAfterCreate($data);

            $transaction->commit();
            return true;
        }catch (\Exception $e){
            $transaction->rollBack();

            $this->_lastError = $e->getMessage();
            return false;
        }
    }

    public static function getList($cond, $curPage = 1, $pageSize = 5, $orderBy = ['id' => SORT_DESC]){
        $model = new Posts();
        //查询语句

        //$select = ['title','id','cat_id','username','user_id','']

        $query = $model->find()->where($cond)->with('relate.tag', 'extend')->orderBy($orderBy);

        //获取分页数据

        $res = $model->getPages($query, $curPage, $pageSize);

        //数据格式化

        $res['data'] = self::_formatList($res['data']);
        //print_r($res['data']);die;

        return $res;

    }
    //格式化数据
    public static function  _formatList($data){
        foreach ($data as $key => $value) {
           //$value['tags'] = [];
           if(isset($value['relate'])  && !empty($value['relate'])){
                $value['tags'] = [];
            //print_r($value['relate']);die;
                foreach ($value['relate'] as $k => $v) {
                    # code...
                    $value['tags'][] = $v['tag']['tags_name'];
                }
           }

           //unset($value[$key]['relate']);
        }
        //print_r($data);die;
        return $data;
    }


    public function getViewById($id){

        //relate.tag  posts模型里面的   方法会自动去找加上get后的名字即  public function getRelate()
        $res = Posts::find()->with('relate.tag', 'extend')->where(['id' => $id])->asArray()->one();

        if(!$res){
             throw new NotFoundHttpException(Yii::t('common','NotPostserror'));
             
        }

        //处理标签格式
        $res['tags'] = [];

        if(isset($res['relate']) && !empty($res['relate'])){
            foreach ($res['relate'] as $key => $value) {
                $res['tags'][] = $value['tag']['tags_name'];
            }
        }
        unset($res['relate']);
        return $res;

        //print_r($res);


    }

    /**
     * 文章简介截取
     *
     * @param number $s 开始长度
     * @param number $e 结束长度
     * @param number $char 编码
     * @return $value|null _getArticleDesc
     */
    public function _getArticleDesc($s = 0, $e = 90, $char = 'utf-8'){
        if(empty($this->content)) return null;

        return (mb_substr(str_replace('&nbsp;', '', strip_tags($this->content)), $s, $e ,$char));
    }

    /**
     * 文章创建后的事件
     *
     * @param array $data 
     * @return $value|null _getArticleDesc
     */
    public function _eventAfterCreate($data){
        $this->on(self::EVENT_AFTER_CREATE, [$this,'_eventAddTag'], $data); //添加事件
        //触发事件
        $this->trigger(self::EVENT_AFTER_CREATE);
        return true;
    }

    /**
     * 添加标签
     *
     * @param 
     * @return $value|null _getArticleDesc
     */

    public function _eventAddTag($event){

        //保存标签
        $tag = new TagsForm();
        $tag->tags = $event->data['tags'];
        
    
        $tagids = $tag->saveTags();
        //print_r($tagids);

        //删除原先的关联标签
        RelationPostTags::deleteAll(['post_id' => $event->data['id']]);

        //批量

        if(!empty($tagids)){
            foreach ($tagids as $key => $value) {
                $row[$key]['post_id'] = $this->id;
                $row[$key]['tags_id'] = $value;
            }

            //批量插入
            $res = (new Query())->createCommand()
            ->batchInsert(RelationPostTags::tableName(),['post_id', 'tags_id'], $row)->execute();
            //返回结果
            if(!$res)  throw new \Exception(Yii::t('common','Tagscreateerror'));
        }
    }
}
