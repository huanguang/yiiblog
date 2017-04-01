<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CatsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('common','Cats');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cats-index">

    <h1 style="display:none;"><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('common','Create Cats'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id:raw:'.Yii::t('common','ID'),
            'catname:raw:'.Yii::t('common','Catsname'),

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('common','header'),
            ],
        ],
    ]); ?>
</div>
