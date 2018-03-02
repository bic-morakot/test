<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\resource\models\ResGroup */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Res Group',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Res Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="res-group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
