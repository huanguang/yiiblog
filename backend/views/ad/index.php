<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '广告';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ad-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加广告', ['create'], ['class' => 'btn btn-success']) ?>
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
            'adposition'=>[
                    'attribute' => 'adposition.name',
                    'label' => '分类',
            ],
            'name' => [
                'attribute' =>'name',
                'label' => '标题',
                //'value'
            ],
            'desc' => [
                'attribute' => 'desc',
                'value' => function ($model){
                    return ($model->desc == 1) ? '从高到低' : '从低到高';
                },
                'filter' => ['0' => '从低到高', '1' => '从高到低'],
                'label' =>'排序'
            ],
            'is_show' => [
                'attribute' => 'is_show',
                'value' => function ($model){
                    return ($model->is_show == 1) ? '显示' : '不显示';
                },
                'filter' => ['0' => '不显示', '1' => '显示'],
                'label' =>'是否显示'
            ],
            // 'imageurl:url',
            // 'linkurl:url',
            // 'is_linkurl:url',
            // 'order',

            ['class' => 'yii\grid\ActionColumn','header' => Yii::t('common','header')],
        ],
    ]); ?>
</div>
