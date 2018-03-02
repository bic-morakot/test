<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\resource\models\ResUsers */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Res Users',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Res Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="res-users-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
