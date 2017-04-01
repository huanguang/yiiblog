<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
    //     echo Yii::$app->redis->get('test');   //读取redis缓存
    // exit;
        //$redis = Yii::$app->redis;
        // $i = 0;
        // for ($i; $i < 50000; $i++) { 
        //     $redis->rpush('lists',$i.'aaa'.$i);

        // }
//         Yii::$app->redis->rpush('list', 'aaa');
// Yii::$app->redis->rpush('list', 'bbb');
// Yii::$app->redis->rpush('list', 'ccc');

//$data = Yii::$app->redis->lrange('lists',0,60000); //redis

// $command = Yii::$app->db->createCommand('SELECT * FROM ceshi');  40.272
// $data = $command->queryAll();

// Yii::$app->db->createCommand()->batchInsert('user', ['name'], [  
//     ['test01', 30],  
//     ['test02', 20],  
//     ['test03', 25],  
// ])->execute();

// $aa = [  
//     ['test01'],  
//     ['test02'],  
//     ['test03'],  
// ];
// $dd = array();
// //print_r($aa);die;
// $cc = count($data);
// for ($i=0; $i < $cc; $i++) { 
//     $dd[$i][] = $data[$i];
// }
//print_r($dd);die;
        //Yii::$app->db->createCommand()->batchInsert('ceshi', ['name'],$dd)->execute();
//print_r($data);die;
        //print_r($redis->srange('ceshi',0,10000));die;

        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = 'login.php';//单个方法定义布局文件
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
