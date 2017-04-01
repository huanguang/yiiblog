<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent
 * @property string $route
 * @property integer $order
 * @property resource $data
 *
 * @property Menu $parent0
 * @property Menu[] $menus
 */
class Menus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'order'], 'integer'],
            [['data'], 'string'],
            [['name'], 'string', 'max' => 128],
            [['route'], 'string', 'max' => 256],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['parent' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'parent' => 'Parent',
            'route' => 'Route',
            'order' => 'Order',
            'data' => 'Data',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent0()
    {
        return $this->hasOne(Menus::className(), ['id' => 'parent']);
    }

    /**
     * 查询菜单列表
     */
    public static function getList($where = null)
    {
        $list = Menus::find()->where(['parent' => $where ])->orderBy('order asc')->asArray()->all();
        foreach ($list as $key => $value) {
            
            $list[$key]['subset'] = Menus::getsubset($value['id']);
        }
        return Menus::getAsarray($list);
    }


    //格式化菜单数组
    public static function getAsarray($data){
        $menulist = $data;
        foreach ($menulist as $key => $value) {
             if(!empty($value['subset'])){
                $item[$key]['label'] = '<a href=""><i class="fa fa-'.$value['data'].'"></i><span>'.$value['name'].'</span></a>';
                $item[$key]['label'] = '<i class="fa fa-'.$value['data'].'"></i><span>'.$value['name'].'</span>';
                $item[$key]['options'] = ['class' => 'nav-parent'];
                $item[$key]['url'] = array($value['route']);
                foreach ($value['subset'] as $k => $v) {
                    $item[$key]['items'][] = array(
                            'label' => $v['name'],
                            'url' => array($v['route']),
                            'items' => [
                            ['label'=>'创建','url'=>[str_replace('index','create',$v['route'])],'visible'=>false],
                            ['label'=>'更新','url'=>[str_replace('index','update',$v['route'])],'visible'=>false],
                            ['label'=>'详情','url'=>[str_replace('index','view',$v['route'])],'visible'=>false],
                            ],
                        );
                }
             }else{
                $item[$key]['label'] = '<i class="fa fa-'.$value['data'].'"></i><span>'.$value['name'].'</span>';
                $item[$key]['url'] = array($value['route']);
             }            
         }
         return $item;
    }

    /**
     * 查询子集菜单列表
     */
    public static function getsubset($where = null)
    {
        $list = Menus::find()->where(['parent' => $where ])->orderBy('order asc')->asArray()->all();
        return $list;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenus()
    {
        return $this->hasMany(Menus::className(), ['parent' => 'id']);
    }
}
