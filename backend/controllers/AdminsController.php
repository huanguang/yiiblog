<?php

namespace backend\controllers;

use Yii;
use app\models\Admin;
use yii\base\Model;
use yii\Helpers\Html;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Region;

/**
 * AdminController implements the CRUD actions for Admin model.
 */
class AdminsController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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
                    'imagePathFormat' => Yii::$app->params['adminimgurl']."/image/avatar/{yyyy}{mm}{dd}/{time}{rand:6}",
                ]
            ],
            // 'get-region' => [//省市区三级联动配置
            //     'class'=>\chenkby\region\RegionAction::className(),
            //     'model'=>\common\models\Region::className()
            // ],

        ];
    }
//     public function actions()
// {
//     $actions=parent::actions();
//     $actions['get-region']=[
//         'class'=>\chenkby\region\RegionAction::className(),
//         'model'=>\common\models\Region::className()
//     ];
//     $actions['upload'] = [//图片上传插件
//                 'class' => 'common\widgets\file_upload\UploadAction',     //这里扩展地址别写错
//                 'config' => [
//                     'imagePathFormat' => Yii::$app->params['adminimgurl']."/image/avatar/{yyyy}{mm}{dd}/{time}{rand:6}",
//                 ]
//             ];
//     return $actions;
// }

    /**
     * Lists all Admin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Admin::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Function output the site that you selected.
     * @param int $pid
     * @param int $typeid
     */
    public function actionSite($pid, $typeid = 0)
    {
        
        $model = new Region();

        $model = $model->getCityList($pid);

        if($typeid == 1){
            $aa="--请选择市--";
        }else if($typeid == 2 && $model){
            $aa="--请选择区--";
        }

        echo Html::tag('option',$aa, ['value'=>'empty']) ;
        $pid = intval($pid);
        if(!empty($pid)){

        
            foreach($model as $value=>$name)
            {
                echo Html::tag('option',Html::encode($name),array('value'=>$value));
            }
        }
    }

    /**
     * Displays a single Admin model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Admin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Admin();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Admin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if(Yii::$app->request->post()){
            $res = Yii::$app->request->post('Admin');
            //print_r($data);die;
            $data = array();
            $region = array();
            $data['password'] = $res['password'];
            $data['new_password'] = $res['new_password'];
            $data['new_passwords'] = $res['new_passwords'];
            $region['province'] = $res['province'];
            $region['city'] = $res['city'];
            $region['area'] = $res['area'];

        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //print_r($model->password);die;

            //更新地址栏
            $model->RegionUpdate($region);
            //新增密码修改操作
            //调用事件
            //$model->setAttributes($this->attributes,false);//数据设置到$model里面 第二个参数设置表示不检测字段安全
            //$data = array_merge($this->getAttributes(),$model->getAttributes());
            if($data['password'] && $data['new_password'] && $data['new_passwords']){
                //print_r($data);die;
                $model->updatepassword($data);
                Yii::$app->session->setFlash('warning',$model->_lastError);  
            }
               
                      
                return $this->redirect(['update', 'id' => $model->id]);
            } else {

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Admin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Admin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Admin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
