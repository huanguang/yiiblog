<?php
namespace backend\widgets\sidebar;

/**
 * 后台siderbar插件
 */
use Yii;
use yii\base\Widget;
use yii\helpers\Url;
use yii\widgets\Menu;
use backend\models\Menus;
use yii\helpers\Html;

class SidebarWidget extends Menu
{    
    public $submenuTemplate = "\n<ul class=\"children\">\n{items}\n</ul>\n";
    
    public $options = ['class'=>'nav nav-pills nav-stacked nav-quirk'];
    
    public $activateParents = true;
    
    public function init()
    {

        //组装数据
        $item = array();
         $menulist = Menus::getList(null);

         
         
        // $this->items = [
        //     ['label' =>'<i class="fa fa-dashboard"></i><span>仪表盘</span>','url'=>['/site/index']],
        //     ['label' =>'<a href=""><i class="fa fa-cogs"></i><span>权限管理</span></a>','options'=>['class'=>'nav-parent'],'items'=>[
        //             ['label'=>'用户列表','url'=>['/admin/user/index'],'items'=>[
        //                 ['label'=>'创建文章','url'=>['/admin/user/view'],'visible'=>false],
        //                 ['label'=>'更新文章','url'=>['/admin/user/activate'],'visible'=>false],
        //                 //['label'=>'文章详情','url'=>['post/view'],'visible'=>false],
        //                 ]                       
        //             ],
        //             ['label'=>'分配','url'=>['/admin/assignment/index'],'items'=>[
        //                 ['label'=>'创建分类','url'=>['/admin/assignment/view'],'visible'=>false],
        //                 ['label'=>'更新分类','url'=>['cats/update'],'visible'=>false],
        //                 ['label'=>'分类详情','url'=>['cats/view'],'visible'=>false],
        //                 ]                        
        //             ],
        //             ['label'=>'角色列表','url'=>['/admin/role/index'],'items' => [
        //                 ['label'=>'创建标签','url'=>['/admin/role/create'],'visible'=>false],
        //                 ['label'=>'更新标签','url'=>['/admin/role/update'],'visible'=>false],
        //                 ['label'=>'标签详情','url'=>['/admin/role/view'],'visible'=>false],
        //                 ]
        //             ],
        //             ['label'=>'权限列表','url'=>['/admin/permission/index'],'items' => [
        //                 ['label'=>'创建标签','url'=>['/admin/permission/create'],'visible'=>false],
        //                 ['label'=>'更新标签','url'=>['/admin/permission/update'],'visible'=>false],
        //                 ['label'=>'标签详情','url'=>['/admin/permission/view'],'visible'=>false],
        //                 ]
        //             ],
        //             ['label'=>'路由列表','url'=>['/admin/route/index']
        //             ],
        //             ['label'=>'规则列表','url'=>['/admin/rule/index'],'items' => [
        //                 ['label'=>'创建标签','url'=>['/admin/rule/create'],'visible'=>false],
        //                 ['label'=>'更新标签','url'=>['/admin/rule/update'],'visible'=>false],
        //                 ['label'=>'标签详情','url'=>['/admin/rule/view'],'visible'=>false],
        //                 ]
        //             ],
        //             ['label'=>'菜单列表','url'=>['/admin/menu/index'],'items' => [
        //                 ['label'=>'创建标签','url'=>['/admin/admin/menu/create'],'visible'=>false],
        //                 ['label'=>'更新标签','url'=>['/admin/menu/update'],'visible'=>false],
        //                 ['label'=>'标签详情','url'=>['/admin/menu/view'],'visible'=>false],
        //                 ]
        //             ],

        //         ]
        //     ],
        //     ['label' =>'<i class="fa fa-cog fa-spin"></i><span>网站设置</span>','url'=>['/config/index']],
        //     ['label' =>'<a href=""><i class="fa fa-th-list"></i><span>内容管理</span></a>','options'=>['class'=>'nav-parent'],'items'=>[
        //             ['label'=>'文章管理','url'=>['/post/index'],'items'=>[
        //                 ['label'=>'创建文章','url'=>['/post/create'],'visible'=>false],
        //                 ['label'=>'更新文章','url'=>['/post/update'],'visible'=>false],
        //                 ['label'=>'文章详情','url'=>['/post/view'],'visible'=>false],
        //                 ]                       
        //             ],
        //             ['label'=>'分类管理','url'=>['/cats/index'],'items'=>[
        //                 ['label'=>'创建分类','url'=>['/cats/create'],'visible'=>false],
        //                 ['label'=>'更新分类','url'=>['/cats/update'],'visible'=>false],
        //                 ['label'=>'分类详情','url'=>['/cats/view'],'visible'=>false],
        //                 ]                        
        //             ],
        //             ['label'=>'标签管理','url'=>['/tags/index'],'items' => [
        //                 ['label'=>'创建标签','url'=>['/tags/create'],'visible'=>false],
        //                 ['label'=>'更新标签','url'=>['/tags/update'],'visible'=>false],
        //                 ['label'=>'标签详情','url'=>['/tags/view'],'visible'=>false],
        //                 ]
        //             ],

        //         ]
        //     ],
        //     ['label' =>'<a href=""><i class="fa fa-user"></i><span>会员管理</span></a>','options'=>['class'=>'nav-parent'],'items'=>[
        //             ['label'=>'会员信息','url'=>['/user/index'], 'items' =>[
        //                     ['label'=>'更新会员','url'=>['/user/update'], 'visible' => false],
        //                     ['label'=>'会员详情','url'=>['/user/view'], 'visible' => false],
        //                 ]
        //             ],
        //         ]
        //     ],
        // ];

        $this->items = $menulist;
        //print_r($this->items);
    }


    /**
     * Normalizes the [[items]] property to remove invisible items and activate certain items.
     * @param array $items the items to be normalized.
     * @param boolean $active whether there is an active child menu item.
     * @return array the normalized menu items
     */
    protected function normalizeItems($items, &$active)
    {
        foreach ($items as $i => $item) {
            if (!isset($item['label'])) {
                $item['label'] = '';
            }
            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $items[$i]['label'] = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $hasActiveChild = false;
            if (isset($item['items'])) {
                $items[$i]['items'] = $this->normalizeItems($item['items'], $hasActiveChild);
                if (empty($items[$i]['items']) && $this->hideEmptyItems) {
                    unset($items[$i]['items']);
                    if (!isset($item['url'])) {
                        unset($items[$i]);
                        continue;
                    }
                }
            }
            if (!isset($item['active'])) {
                if ($this->activateParents && $hasActiveChild || $this->activateItems && $this->isItemActive($item)) {
                    $active = $items[$i]['active'] = true;
                } else {
                    $items[$i]['active'] = false;
                }
            } elseif ($item['active']) {
                $active = true;
            }
             
            if (isset($item['visible']) && !$item['visible']) {
                unset($items[$i]);
                continue;
            }
        }
        //print_r(array_values($items));
        return array_values($items);
    }
}