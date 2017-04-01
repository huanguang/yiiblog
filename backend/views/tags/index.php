<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TagsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('common','Tags');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tags-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('common','Create Tags'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'tags_name:raw:'.Yii::t('common','tags_name'),
            'post_num:raw:'.Yii::t('common','post_num'),

            ['class' => 'yii\grid\ActionColumn','header' => Yii::t('common','header')],
        ],
    ]); ?>
</div>
