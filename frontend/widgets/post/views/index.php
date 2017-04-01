<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>

<div class="panel">
	<div class="panel-title box-title">
		<span style="display:none;"><?=$data['title']?></span>
		<?php if($this->context->more):?>
			<span class="pull-right"><a href="<?= $data['more']?>" class="font-title">更多</a></span>
		<?php endif;?>
	</div>
	<div class="new-list">
	<?php foreach($data['body'] as $list):?>
		<div class="panel-body border-bottom">
			<div class="row">
				<div class="col-lg-4 label-img-size">
					<a href="<?php echo  Url::to(['post/view','id' => $list['id']]);?>" class="post-label">
						<img style="width:79%;" src="<?=$list['label_img']?>">
					</a>
					
				</div>
				<div class="col-lg-8">
					<span class="title">
						<a href="<?php echo  Url::to(['post/view','id' => $list['id']]);?>">
							<h3><?=$list['title']?></h3>
						</a>
					</span>
					<span><i class="fa fa-user"></i> <?= $list['username']?></span>
					<span><i class="fa fa-clock-o"></i> <?= date('Y-m-d H:i:s',$list['created_at'])?></span>
					<span><i class="fa fa-eye"></i> <?= $list['extend']['browser'] ?$list['extend']['browser']: 0 ?>次浏览</span>
					<p class="post-content"><?= $list['desc']?></p>
					<a href="<?php echo  Url::to(['post/view','id' => $list['id']]);?>">阅读全文</a>
				</div>
			</div>
			<div class="tags">
				<?php if(!empty($list['relate'])):?>
					<span class="fa fa-tags"></span>
					<?php foreach($list['relate'] as $tag):?>
						<a href="javascript:;"><?=$tag['tag']['tags_name']?></a>
					<?php endforeach;?>
				<?php endif;?>
			</div>
		</div>
	<?php endforeach;?>
		
	</div>
	
</div>

<?php if($this->context->page):?>
	<div class="page">
		<?= LinkPager::widget(['pagination' => $data['page']]);?>
	</div>
<?php endif;?>