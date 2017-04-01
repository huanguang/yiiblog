<?php
use yii\helpers\Url;
?>

<div class="img-wall" style="width:660">

        <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="4000" >

            <ol class="carousel-indicators">
            	<?php foreach($data['itme'] as $key => $value):?>
	                <li data-target="#myCarousel" data-slide-to="<?=$key?>" class="<?php if($key == 0):?>active<?php endif;?>"></li>
                <?php endforeach;?>
            </ol>

            <div class="carousel-inner">
            	<?php foreach($data['itme'] as $key => $value):?>
	                <div class="item <?php if($key == 0):?>active<?php endif;?>">
	                    <img src="<?= $value['image_url']?>" style="width:100%;height:350px;" alt="<?= $value['label']?>">
	                    <div class="carousel-caption"><?= $value['label']?></div>
	                </div>
            	<?php endforeach;?>
                
            </div>

            <a class="carousel-control left" href="#myCarousel"
               data-slide="prev">&lsaquo;</a>
            <a class="carousel-control right" href="#myCarousel"
               data-slide="next">&rsaquo;</a>
        </div>
    </div>