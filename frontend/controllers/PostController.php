<?php


namespace frontend\controllers;
use Yii;
use frontend\models\PostsForm;
use frontend\models\Postextends;
use frontend\models\Cats; //分类model
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
class PostController extends \yii\web\Controller
{


	/**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create','upload', 'ueditor'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        //'roles' => ['?'],// ？ 不登陆才可以访问
                    ],
                    [
                        'actions' => ['create','upload', 'ueditor'],
                        'allow' => true,
                        'roles' => ['@'],//@ 登陆之后才能访问
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                	'*' => ['post', 'get'], //所有方法都可以用post/get访问
                    'create' => ['post','get'],
                ],
            ],
            //页面缓存
            [
                'class' => 'yii\filters\PageCache',
                'only' => ['index','create','view'],//当前控制器开启缓存的方法
                'duration' => 1200,//缓存时间设置
                'variations' => [
                    \Yii::$app->language,
                ],
                'dependency' => [
                    'class' => 'yii\caching\DbDependency',
                    'sql' => 'SELECT COUNT(*) FROM posts',
                ],
            ],
        ];
    }

	public function actions()
    {
        return [
            'upload'=>[//图片上传插件
                'class' => 'common\widgets\file_upload\UploadAction',     //这里扩展地址别写错
                'config' => [
                    'imagePathFormat' => Yii::$app->params['imgurl']."/image/post/{yyyy}{mm}{dd}/{time}{rand:6}",//这里需要配置绝对路径
                ]
            ],
            'ueditor'=>[//百度编辑器
            'class' => 'common\widgets\ueditor\UeditorAction',
            'config'=>[
                //上传图片配置
                'imageUrlPrefix' => "", /* 图片访问路径前缀 */
                'imagePathFormat' => Yii::$app->params['imgurl']."/image/ueditor/post/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
            ]
        ]
        ];
    }
	//文章列表
    public function actionIndex()
    {
        return $this->render('index');
    }

    //创建文章

    public function actionCreate(){
    	$model = new PostsForm();

    	//定义场景
    	$model->setScenario(PostsForm::SCENARIOS_CREATE);//通过常量设置
    	if($model->load(Yii::$app->request->post()) && $model->validate()){
    		//echo 23424;die;
    		if(!$model->create()){
    			Yii::$app->session->setFlash('warning',$model->_lastError);
	    	}else{
	    		return $this->redirect(['post/view','id'=> $model->id]);
	    	}

    	}

    	//$cat = new Cats();
    	$catlist = Cats::GetallCats();  //获取文章分类
    	//print_r($catlist);die;
    	return $this->render('create',['model' => $model, 'catlist' => $catlist]);

    }



    public function actionView($id){
    	$model = new PostsForm();
    	$data = $model->getViewById($id);
    	//记录文章统计
    	$model = new Postextends();//文章扩展记录
    	$model->UpCounter(['post_id' => $id],'browser',1);

    	return $this->render('view',['data' => $data]);
    }

}
