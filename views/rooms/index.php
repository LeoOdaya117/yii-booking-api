<?php

use app\models\Rooms;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\models\RoomsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Rooms';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rooms-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Rooms', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

   
    <table class="table table-striped table-bordered">
        <thead>
            <tr class="text-center">
                <th>ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dataProvider->models as $model): ?>
            <tr class="text-center">
                <td><?= Html::encode($model->id) ?></td>
                <td><?= Html::encode($model->room_number) ?></td>
                <td><?= Html::encode($model->room_type) ?></td>
                <td><?= Html::encode($model->price) ?></td>
                <td>
                    <?= Html::a('View', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
