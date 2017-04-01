<?php
namespace common\widgets\region;
/**
 * 标签云组件
 */
use Yii;
use yii\widgets\InputWidget;
use yii\web\View;
use yii\helpers\Html;
use common\widgets\region\assets\RegionAsset;
use common\models\Region;

class RegionWidget extends InputWidget
{
    public $value = '';
    
    public function init()
    {
        
    }
    
    public function run()
    {

        $this->registerClientScript();
        if($this->hasModel()){
            //$data['inputName'] = Html::getInputName($this->model, $this->attribute);
            //$data['inputValue'] = Html::getAttributeValue($this->model, $this->attribute);
        }else{
            //$data['inputName'] = 'wd-tags';
            //$data['inputValue'] = $this->value;
        }
        if($this->model->addres){
            $data['province'] = $this->model->province;
            $data['city'] = $this->model->city;
            $data['area'] = $this->model->area;
        }else{
            $data = array();
        }
        
        return $this->render('index',['data'=>$data]);
    }
    
    /**
     * 注册Js
     */
    protected function registerClientScript()
    {
         RegionAsset::register($this->view);
         $script = '';
         $this->view->registerJs($script, View::POS_END);
    }
}