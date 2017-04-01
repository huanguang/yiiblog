<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Cats */

$this->title = Yii::t('common','Create Cats');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common','Cats'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cats-create">

    <h1 style="display:none;"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
