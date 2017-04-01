<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Posts */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common','Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('common','Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('common','Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'title' => [
                'attribute' => 'title',
                'label' => '标题',
                'format' => 'raw',
                'value' => function ($model){
                    return '<a href="'.Yii::$app->params['homeurl'].Url::to(['post/view','id'=>$model->id]).'">'.$model->title.'</a>';
                },
            ],
            'label_img'=> [
                //'attribute' => 'label_img',
                'label' => '标签图',
                'format' => 'raw',
                'value' => function ($model){
                    return '<img class="img-circle" src="'.Yii::$app->params['homeurl'].$model->label_img.'" width="70" alt="">';
                },
            ],
            'content:ntext',
            'cats.catname' => [
                'attribute' =>'cats.catname',
                'label' => '分类',
                //'value' 
            ],
            'desc',
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
            'username',
            //'user_id',
            'tags',
            'is_valid' => [
                'attribute' => 'is_valid',
                'label' => '状态',
                'value' => function ($model){
                    return ($model->is_valid == 1) ? Yii::t('common','no_valid') : Yii::t('common','off_valid');
                },
            ],
        ],
    ]) ?>

</div>
