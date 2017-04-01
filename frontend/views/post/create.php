<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Archives;




$this->title = Yii::t('common','Establish');//设置标题
$this->params['breadcrumbs'][] = ['label' => Yii::t('common','Posts'), 'url' => ['post/index']];//设置网页所在位置导航
$this->params['breadcrumbs'][] = $this->title; //设置当前所在位置



?>
<div class="row">
	<div class="col-lg-9">
		<div class="panel-title box-title">
			<span>创建文章</span>
		</div>
		<div class="panel-body">
			<?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'cat_id')->dropDownList($catlist) ?>

                <?= 
                //$form->field($model, 'content')->textInput()
                //引用Yii自带的文本编辑器
                //$form->field($model, 'content')->widget(\yii\redactor\widgets\Redactor::className()) 
                //调用百度编辑器
                $form->field($model, 'content')->widget('common\widgets\ueditor\Ueditor',[
				    'options'=>[
				        'initialFrameHeight' => 400,
				    ]
				])

                ?>

                <?= 
                	//调用tags组件填写标签
                $form->field($model, 'tags')->widget('common\widgets\tags\TagWidget') ?>

                

                <?=
                //$form->field($model, 'label_img')->textInput(['maxlength' => true])
                //调用上传图片组件
                 $form->field($model, 'label_img')->widget('common\widgets\file_upload\FileUpload',[
				        'config'=>[
				            //图片上传的一些配置，不写调用默认配置
				            'domain_url' => Yii::$app->params['homeurl'],
				        ]
				    ]) ?>

                
                

                <div class="form-group">
                    <?= Html::submitButton('发布', ['class' => 'btn btn-success']) ?>
                </div>

            <?php ActiveForm::end(); ?>
		</div>
	</div>

	<div class="col-lg-3">
		<div class="panel-title box-title">
			<span>
				注意事项
			</span>
			
		</div>
		<div class="panel-body">
			<div>234234234dasd</div>
			<div>asdddddddd</div>
		</div>
		
	</div>

</div>