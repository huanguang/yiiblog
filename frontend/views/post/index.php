<?php
/* @var $this yii\web\View */
use yii\base\Widget;
use frontend\widgets\post\PostWidget;


$this->title = Yii::t('common','NewPost');//设置标题
$this->params['breadcrumbs'][] = ['label' => Yii::t('common','Posts'), 'url' => ['post/index']];//设置网页所在位置导航
$this->params['breadcrumbs'][] = $this->title; //设置当前所在位置
?>



<div class="row">
	<div class="col-lg-9">
		<?= PostWidget::Widget(['limit' => 5, 'title' => $this->title])?>
	</div>
	<div class="col-lg-3">
		
	</div>
</div>