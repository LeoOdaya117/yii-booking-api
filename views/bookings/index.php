<?php

use app\models\Bookings;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\BookingsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Bookings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bookings-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Bookings', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <table class="table table-striped table-bordered">
        <thead>
            <tr class="text-center">
                <th>#</th>
                <th>ID</th>
                <th>Customer Name</th>
                <th>Checkin Date</th>
                <th>Checkout Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dataProvider->models as $index => $model): ?>
                <tr class="text-center">
                    <td><?= $index + 1 ?></td>
                    <td><?= Html::encode($model->id) ?></td>
                    <td><?= Html::encode($model->user->name) ?></td>
                    <td><?= Html::encode($model->check_in_date) ?></td>
                    <td><?= Html::encode($model->check_out_date) ?></td>
                    <td><?= Html::encode($model->status) ?></td>
                    <td>
                        <?= Html::a('View', ['view', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
                        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-warning btn-sm']) ?>
                        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-sm',
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
