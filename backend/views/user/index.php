<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\dialog\Dialog;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('common','Users');
$this->params['breadcrumbs'][] = $this->title;

// widget with default options
echo Dialog::widget();
 
// buttons for testing the krajee dialog boxes
$btns = <<< HTML
<button type="button" id="btn-alert" class="btn btn-info">Alert</button>
<button type="button" id="btn-confirm" class="btn btn-warning">Confirm</button>
<button type="button" id="btn-prompt" class="btn btn-primary">Prompt</button>
<button type="button" id="btn-dialog" class="btn btn-default">Dialog</button>
HTML;
echo $btns;
 
// javascript for triggering the dialogs
$js = <<< JS
$("#btn-alert").on("click", function() {
    krajeeDialog.alert("This is a Krajee Dialog Alert!")
});
$("#btn-confirm").on("click", function() {
    krajeeDialog.confirm("Are you sure you want to proceed?", function (result) {
        if (result) {
            alert('Great! You accepted!');
        } else {
            alert('Oops! You declined!');
        }
    });
});
$("#btn-prompt").on("click", function() {
    krajeeDialog.prompt({label:'Provide reason', placeholder:'Upto 30 characters...'}, function (result) {
        if (result) {
            
        } else {
            alert('Oops! You declined to provide a reason!');
        }
    });
});
$("#btn-dialog").on("click", function() {
    krajeeDialog.dialog(
        'This is a <b>custom dialog</b>. The dialog box is <em>draggable</em> by default and <em>closable</em> ' +
        '(try it). Note that the Ok and Cancel buttons will do nothing here until you write the relevant JS code ' +
        'for the buttons within "options". Exit the dialog by clicking the cross icon on the top right.',
        function (result) {alert(result);}
    );
});
JS;
 
// register your javascript
$this->registerJs($js);
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('common','Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'value' => function($model) {
                    if (isset($model['id'])) {
                        return $model['id'];
                    }
                },
                'attribute' => 'id', //用于排序，如果不写，不能点击表头排序，非必须
                'label' => '编号', // 自定义表头，非必须
                'format' => 'raw', // 格式方式，非必须
                ],
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            'status' => [
                    'attribute' => 'status',
                    'value' => function ($model){
                        return ($model->status == 10) ? '激活' : '非激活';
                    },
                    'filter' => ['0' => '非激活', '10' => '激活'],
                ],
            'created_at' => [
                    'attribute' => 'created_at',
                    'label' => '注册时间',
                    'value' => function ($model){
                        return date('Y-m-d H:i:s',$model->created_at);
                    },
            ],
            // 'updated_at',
            'avatar' => [
                'label' => '头像',
                'format' => 'raw',
                'value' => function ($model){
                    return Html::img($model->avatar,
                    ['class' => 'img-circle',
                    'width' => 70]
                    );
                },
            ],
            // 'email_validate_token:email',
            // 'role',
            'vip_lv' =>[
                'label' => 'vip等级',
                'attribute' => 'vip_lv',
                'value' => function ($model){
                    return $model->vip_lv;
                },
            ],

            [
                //动作列yii\grid\ActionColumn 
                //用于显示一些动作按钮，如每一行的更新、删除操作。
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作', 
                //'template' => '{delete} {update}',//只需要展示删除和更新
                //'headerOptions' => ['width' => '200'],
                
                
            ],
        ],
    ]); ?>
</div>
