<?php
namespace frontend\widgets\post;

//文章列表组件
use Yii;
use yii\base\Widget;
use frontend\models\Posts;
use frontend\models\PostsForm;
use yii\helpers\Url;
use yii\data\Pagination;
class Postwidget extends Widget{

	public $title = ''; //文章列表标题
	public $limit = 10; //默认显示条数

	public $more = true; //是否显示更多
	public $page = true; //是否显示分页


	public function run(){

		$curPage = Yii::$app->request->get('page',1);
		//设置查询条件
		$cond = ['=','is_valid',Posts::IS_VALID];
		//print_r($cond);die;
		$res = PostsForm::getList($cond, $curPage, $this->limit);
		//print_r($res);die;
		$result['title'] = $this->title ? : "最新文章";
		$result['more'] = Url::to(['post/index']);
		$result['body']  = $res['data'] ? : [];
		//是否显示分页
		if($this->page){
			$pages = new Pagination(['totalCount' => $res['count'], 'pageSize' => $res['pageSize']]);//分页
			$result['page'] = $pages;
		}
		//print_r($pages);
		//print_r($result);die;
		return $this->render('index',['data' => $result]);
	}
}
?>