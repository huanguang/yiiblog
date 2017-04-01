<?php
namespace frontend\widgets\chat;

//chat组件
use Yii;
use yii\base\Widget;
use frontend\models\FeedsForm;

class ChatWidget extends Widget{
	public function run(){

		$feed = new FeedsForm();

		$data['feed'] = $feed->getList();
		//print_r($data['feed']);die;
		return $this->render('index',['data' => $data]);
	}
}