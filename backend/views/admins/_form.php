<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Region;

/* @var $this yii\web\View */
/* @var $model app\models\Admin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'address')->textInput() ?>
    <?= $form->field($model, 'iphone')->textInput() ?>
    <?=
                //$form->field($model, 'label_img')->textInput(['maxlength' => true])
                //调用上传图片组件
                 $form->field($model, 'avatar')->widget('common\widgets\file_upload\FileUpload',[
                        'config'=>[
                            //图片上传的一些配置，不写调用默认配置
                            'domain_url' => '',
                        ]
                    ]) ?>


     <?= $form->field($model,'province')->dropDownList($model->getCityList(1),
    [
        'prompt'=>'--请选择省--',
        'onchange'=>'
            $(".form-group.field-member-area").hide();
            $.post("'.yii::$app->urlManager->createUrl('admins/site').'?typeid=1&pid="+$(this).val(),function(data){
                $("select#admin-city").html(data);
            });',
    ]) ?>

<?= $form->field($model, 'city')->dropDownList($model->getCityList($model->province),
    [
        'prompt'=>'--请选择市--',
        'onchange'=>'
            $(".form-group.field-member-area").show();
            $.post("'.yii::$app->urlManager->createUrl('admins/site').'?typeid=2&pid="+$(this).val(),function(data){
                $("select#admin-area").html(data);
            });',
    ]) ?>

<?= $form->field($model, 'area')->dropDownList($model->getCityList($model->city),['prompt'=>'--请选择区--',]) ?>


     <?= $form->field($model, 'addres')->hiddenInput()

     //$form->field($model, 'district')->widget(\chenkby\region\Region::className(),[
//     'model'=>$model,
//     'url'=> \yii\helpers\Url::toRoute(['get-region']),
//     'province'=>[
//         'attribute'=>'province',
//         'items'=>Region::getRegion(),
//         'options'=>['class'=>'form-control form-control-inline','prompt'=>'选择省份']
//     ],
//     'city'=>[
//         'attribute'=>'city',
//         'items'=>Region::getRegion($model['province']),
//         'options'=>['class'=>'form-control form-control-inline','prompt'=>'选择城市']
//     ],
//     'district'=>[
//         'attribute'=>'area',
//         'items'=>Region::getRegion($model['city']),
//         'options'=>['class'=>'form-control form-control-inline','prompt'=>'选择县/区']
//     ]
// ]);
?> 


    <?php 
                	//调用地区三级联动组件
                //$form->field($model, 'addres')->widget('common\widgets\region\RegionWidget') ?>
    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'new_password')->passwordInput() ?>

    <?= $form->field($model, 'new_passwords')->passwordInput() ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('common','Create') : Yii::t('common','Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
