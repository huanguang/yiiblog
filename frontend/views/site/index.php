<?php
use frontend\widgets\post\PostWidget;
use frontend\widgets\banner\BannerWidget;
use frontend\widgets\chat\ChatWidget;
use frontend\widgets\hot\HotWidget;
use frontend\widgets\tag\TagWidget;
/* @var $this yii\web\View */

$this->title = '博客-首页';
?>
<div class="row">
    <div class="col-lg-9">
        <!--图片轮播组件 -->
        <?= BannerWidget::Widget()?>
    </div>
    <div class="col-lg-3">
        <!--留言板组件 -->
        <?= ChatWidget::Widget()?>
        
    </div>
    <div class="col-lg-9">
        <!--文章列表组件 -->
        <?= PostWidget::Widget(['limit' => 10, 'page' => false])?>
    </div>
    <div class="col-lg-3">
        <?= HotWidget::Widget()?>
        <?= TagWidget::Widget()?>
    </div>

    
    
</div>
