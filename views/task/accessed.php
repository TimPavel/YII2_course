<?php

use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accessed Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'title',
            'description:ntext',
            [
                'label' => 'Owner\'s username',
                'attribute' => 'title',
                'content' => function($model) {
                    $users = $model->getCreator()->select('username')->column();
                    return join(', ', $users);
                },
            ],
            'created_at:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{deleteAll} {view} {update} {delete}',
                'buttons' => [
                    'deleteAll' => function ($url, $model, $key) {
                        $icon = \yii\bootstrap\Html::icon('remove');
                        return Html::a($icon, ['task-user/delete-all', 'taskId' => $model->id],
                            ['data' => [
                                'confirm' => 'Are you sure you want to unshare all this item?',
                                'method' => 'post',
                            ]]);
                    },
                ]
            ],

        ],
    ]); ?>
</div>
