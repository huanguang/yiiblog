<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Ad */

$this->title = 'Update Ad: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ads', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ad-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'ad_position' => $ad_position,
    ]) ?>

</div>
