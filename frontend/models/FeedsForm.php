<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\Feeds;
/**
 * Posts form
 */
class FeedsForm extends Model
{
    public $content;

    public $_lastError = "";




    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['content'], 'required'], //标题。内容。分类是必须选择的

            ['content', 'string', 'max'=>255],//标题必须是字符串，并且长度只能是4到50之间
        ];
    }


    public function attributeLabels(){
        return [
            'id' => 'ID',
            'content' => Yii::t('common','content'),
        ];
    }

    public function create()
    {
        try{
            $model = new Feeds();
            $model->user_id = Yii::$app->user->identity->id;
            $model->content = $this->content;
            $model->created_at = time();            
            if(!$model->save())
                throw new \Exception('保存失败！');
            
            return true;
        }catch (\Exception $e){
            $this->_lastError = $e->getMessage();
            return false;
        }
    }

    //获取留言板数据
    public static function getList(){
        $model = new Feeds();
        //$res = $model->find()->limit(10)->orderBy(['id' => 'desc'])->asArray()->all();
        $res = $model->find()->limit(10)->with('user')->orderBy(['id'=>SORT_DESC])->asArray()->all();

        //print_r($res);
        return $res ? : [];
    }


   
}
