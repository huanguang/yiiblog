<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use xj\uploadify\Uploadify;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">
<?php
//外部TAG
echo Html::fileInput('test', NULL, ['id' => 'test']);
echo Uploadify::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test', //需要跟上fileInput 的id 对应
    'csrf' => true,
    'renderTag' => false,
     'jsOptions' => [
                  'width' => 100,
                  'height' => 40,
                  'onUploadError' => new JsExpression(<<<EOF
                  function(file, errorCode, errorMsg, errorString) {
                        console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
                    }
EOF
                    ),
                    'onUploadSuccess' => new JsExpression(<<<EOF
                    function(file, data, response) {
                        data = JSON.parse(data);
                        if (data.error) {
                            console.log(data.msg);
                             } else {
                                //在此处理你的图片
                               console.log(data.fileUrl);
                               document.getElementById('imgs').innerHTML = '<img  src="'+data.fileUrl+'"/>';
                               //$(#imgs).html('<img  src="'+data.fileUrl+'"/>');
                               alert('上传成功');

                        }
                    }
EOF
					),
		],
				]);
?>
    <?php $form = ActiveForm::begin(); ?>


<div id="imgs"><img  src="/statics/images/avatar/avatar_1.jpg"/></div>

    <?= $form->field($model, 'status')->dropDownList(['0' => '非激活', '10' => '激活']) ?>
    <?= \hyii2\avatar\AvatarWidget::widget(['imageUrl'=>'/statics/images/avatar/avatar_1.jpg']); ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('common','Create') : Yii::t('common','Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>