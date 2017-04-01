<?php


$this->title = $data['title'];
$this->params['breadcrumbs'][] = ['label' => Yii::t('common','Posts'), 'url' => ['post/index']];//设置网页所在位置导航
$this->params['breadcrumbs'][] = $this->title; //设置当前所在位置
?>


<div class="row">
	<div class="col-lg-9">
		<div class="page-title">
			<h1><?= $data['title']?></h1>
			<span><i class="fa fa-user"></i> <?= $data['username']?></span>
			<span><i class="fa fa-clock-o"></i> <?= date('Y-m-d H:i:s',$data['created_at'])?></span>
			<span><i class="fa fa-eye"></i> <?= $data['extend']['browser'] ?$data['extend']['browser']: 0 ?>次浏览</span>
			<span><a href="#comments"><i class="fa fa-comments-o"></i> 2条评论</a></span>
            <span><a class="favorite" href="javascript:void(0);" title="" data-type="post" data-id="1192" data-toggle="tooltip" data-original-title="收藏"><i class="fa fa-star-o"></i> 6</a></span>
            <span class="pull-right"><a class="vote up" href="javascript:void(0);" title="" data-type="post" data-id="1192" data-toggle="tooltip" data-original-title="顶"><i class="fa fa-thumbs-o-up"></i> 1</a><a class="vote down" href="javascript:void(0);" title="" data-type="post" data-id="1192" data-toggle="tooltip" data-original-title="踩"><i class="fa fa-thumbs-o-down"></i> 0</a></span>
		</div>

		
		<div class="page-content">
			<?= $data['content']?>
		</div>

		

		<div class="page-tag">
			标签：
			<?php foreach($data['tags'] as $tag):?>

				<span><a href="#"><?= $tag?></a></span>
			<?php endforeach;?>
		</div>

	</div>
	<div class="col-lg-3">
		
	</div>
	
</div>