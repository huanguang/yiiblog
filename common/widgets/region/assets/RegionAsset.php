<?php
/**
 * @link http://www.yii-china.com/
 * @copyright Copyright (c) 2015 Yii中文网
 * @license http://www.yii-china.com
 */

namespace common\widgets\region\assets;

use yii\web\AssetBundle;

/**
 * @author Xianan Huang <xianan_huang@163.com>
 * @since 1.0
 */
class RegionAsset extends AssetBundle
{
    public $css = [
        'css/city.css',
    ];  
    
    public $js = [
        'js/jquery.min.js', 
        'js/city.min.js',
           
    ];
    
    /**
     * 初始化：sourcePath赋值
     * @see \yii\web\AssetBundle::init()
     */
    public function init()
    {
        $this->sourcePath = (dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR . 'statics';
    }
}
