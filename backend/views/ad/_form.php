<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Ad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ad-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ad_position')->dropDownList($ad_position) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_show')->dropDownList(['0' => Yii::t('common','off_valid'), '1' => Yii::t('common','no_valid')]) ?>

    <?= //$form->field($model, 'imageurl')->textInput(['maxlength' => true]) 
        $form->field($model, 'imageurl')->widget('common\widgets\file_upload\FileUpload',[
                        'config'=>[
                            //图片上传的一些配置，不写调用默认配置
                            'domain_url' => '',
                        ]
                    ])
    ?>

    <?= $form->field($model, 'linkurl')->dropDownList(['0' => Yii::t('common','否'),'1' => Yii::t('common','是')]) ?>

    <?= $form->field($model, 'is_linkurl')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
