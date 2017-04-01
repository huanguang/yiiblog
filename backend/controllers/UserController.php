<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use xj\uploadify\UploadAction;//上传图片插件

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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

    //在当前控制器的actions中添加如下配置
        public function actions()
        {
            return [
                'crop'=>[
                    'class' => 'hyii2\avatar\CropAction',
                    'config'=>[
                        'bigImageWidth' => '200',     //大图默认宽度
                        'bigImageHeight' => '200',    //大图默认高度
                        'middleImageWidth'=> '100',   //中图默认宽度
                        'middleImageHeight'=> '100',  //中图图默认高度
                        'smallImageWidth' => '50',    //小图默认宽度
                        'smallImageHeight' => '50',   //小图默认高度
                        //头像上传目录（注：目录前不能加"/"）
                        'uploadPath' => 'statics/images/avatar',
                    ]
                ],
                's-upload' => [
                'class' => UploadAction::className(),
                //磁盘目录
                'basePath' => '@webroot/upload',
                //访问目录
                'baseUrl' => '@web/upload',
                //防止跨站攻击
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                //是否覆盖相同文件
                'overwriteIfExist' => true,
                //创建图片名称
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filename = sha1_file($action->uploadfile->tempName);
                    return "{$filename}.{$fileext}";
                },
                 //想要多调用这个函数
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },
                'validateOptions' => [
                    'extensions' => ['jpg', 'png'], //后缀验证
                    'maxSize' => 1 * 1024 * 1024, //上传大小限制
                 ],
                 //验证前处理
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                    },
                 //验证后处理
                'afterValidate' => function (UploadAction $action) {},
                 //保存前处理
                'beforeSave' => function (UploadAction $action) {},
                //保存后处理
                'afterSave' => function (UploadAction $action) {
                    //$action->output 返回给浏览器的数据
                    //返回Url 图片返回的路径
                    //$action->getWebUrl()
                    //图片的名称
                    //$action->getFilename();
                    //保存图片的物理位置
                    //$action->getSavePath();
                    //输出                                 
                    //$action->output['fileUrl'] = $action->getWebUrl();
                    //$action->output['fileName'] = $action->getFilename();
                    //$action->output['filePath'] = $action->getSavePath();
                    //$action->getFilename(); // "image/yyyymmddtimerand.jpg"
                    //$action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
                     //$action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                    $action->output['fileUrl'] = $action->getWebUrl();
                  },
               ],
            ]; 
        }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
