<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Archives;




$this->title = Yii::t('common','Dashboard');//设置标题
//$this->params['breadcrumbs'][] = ['label' => Yii::t('common','Posts'), 'url' => ['post/index']];//设置网页所在位置导航
$this->params['breadcrumbs'][] = $this->title; //设置当前所在位置
?>
