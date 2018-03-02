<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\resource\models\ResUsers */

$this->title = Yii::t('app', 'สร้างผู้ใช้');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Res Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="res-users-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
