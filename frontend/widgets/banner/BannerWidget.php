<?php
namespace frontend\widgets\banner;

//banner组件
use Yii;
use yii\base\Widget;
use common\models\Ad;
class Bannerwidget extends Widget{

	public $item = []; //数据

	public $type = 1;//广告位置


	public function init(){


		$ad = Ad::GetListAd($this->type);
		if(empty($ad)){


			$this->item = [
				['label' => 'dome1', 'image_url' => '/statics/images/banner/b1.jpg', 'url' => ['site/index'], 'html' => '', 'active' => 'active'],
				['label' => 'dome2', 'image_url' => '/statics/images/banner/b2.jpg', 'url' => ['site/index'], 'html' => '', 'active' => 'active'],
				['label' => 'dome3', 'image_url' => '/statics/images/banner/b3.jpg', 'url' => ['site/index'], 'html' => '', 'active' => 'active'],
			];
		}else{
			$this->item = $ad;
		}
	}


	public function run(){
		$data['itme'] = $this->item;
		return $this->render('index',['data' => $data]);
	}
}
?>