<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Posts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="posts-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?=
                //$form->field($model, 'label_img')->textInput(['maxlength' => true])
                //调用上传图片组件
                 $form->field($model, 'label_img')->widget('common\widgets\file_upload\FileUpload',[
                        'config'=>[
                            //图片上传的一些配置，不写调用默认配置
                            'domain_url' => '',
                        ]
                    ]) ?>


    <?= 
                //$form->field($model, 'content')->textarea(['rows' => 6])
                //引用Yii自带的文本编辑器
                //$form->field($model, 'content')->widget(\yii\redactor\widgets\Redactor::className()) 
                //调用百度编辑器
                $form->field($model, 'content')->widget('common\widgets\ueditor\Ueditor',[
                    'options'=>[
                        'initialFrameHeight' => 400,
                    ]
                ])

                ?>


    <?= $form->field($model, 'cat_id')->dropDownList($cat) ?>


    

                <?= 
                //$form->field($model, 'tags')->textInput(['maxlength' => true])
                    //调用tags组件填写标签
                $form->field($model, 'tags')->widget('common\widgets\tags\TagWidget') ?>

                

                




    <?= $form->field($model, 'is_valid')->dropDownList(['0' => Yii::t('common','off_valid'), '1' => Yii::t('common','no_valid')]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('common','Create') : Yii::t('common','Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
