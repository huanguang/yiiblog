<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('common','Posts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-index">

    <h1 style="display:none;"><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('common','Create Posts'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'value' => function($model) {
                    if (isset($model['id'])) {
                        return $model['id'];
                    }
                },
                'attribute' => 'id', //用于排序，如果不写，不能点击表头排序，非必须
                'label' => '编号', // 自定义表头，非必须
                'format' => 'raw', // 格式方式，非必须
                ],
            'title' => [
                'attribute' => 'title',
                'label' => '标题',
                'format' => 'raw',
                'value' => function ($model){
                    return '<a href="'.Yii::$app->params['homeurl'].Url::to(['post/view','id'=>$model->id]).'">'.$model->title.'</a>';
                },
            ],
            // 'label_img'=> [
            //     //'attribute' => 'label_img',
            //     'label' => '标签图',
            //     'format' => 'raw',
            //     'value' => function ($model){
            //         return Html::img($model->label_img,
            //         ['class' => 'img-circle',
            //         'width' => 70]
            //         );
            //     },
            // ],
            //'content:ntext',
            'cats.catname' => [
                'attribute' =>'cats.catname',
                'label' => '分类',
                //'value' 
            ],
            // 'desc',
            'created_at' => [
                    'attribute' => 'created_at',
                    'label' => '创建时间',
                    'value' => function ($model){
                        return date('Y-m-d H:i:s',$model->created_at);
                    },
            ],
            'updated_at' => [
                    'attribute' => 'updated_at',
                    'label' => '更新时间',
                    'value' => function ($model){
                        return date('Y-m-d H:i:s',$model->updated_at);
                    },
            ],
            'username' => [
                'label' => '发布会员',
                'attribute' => 'username',
            ],
            // 'user_id',
            // 'tags',
            'is_valid' => [
                'attribute' => 'is_valid',
                'label' => '状态',
                'value' => function ($model){
                    return ($model->is_valid == 1) ? Yii::t('common','no_valid') : Yii::t('common','off_valid');
                },
                'filter' => ['1' => Yii::t('common','no_valid'), '0' => Yii::t('common','off_valid')],
            ],

            ['class' => 'yii\grid\ActionColumn','header' => Yii::t('common','header')],
        ],
    ]); ?>
</div>
