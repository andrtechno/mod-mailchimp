<?php

use panix\engine\Html;
use panix\engine\widgets\Pjax;
use panix\engine\grid\GridView;

/**
 * @var \yii\data\ArrayDataProvider $dataProvider
 * @var \yii\web\View $this
 */

echo \panix\ext\fancybox\Fancybox::widget(['target' => 'a.thumbnail']);
Pjax::begin();
echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'layoutOptions' => [
        'title' => $this->context->pageName,
    ],
    'columns' => [
        [
            'attribute' => 'thumbnail',
            'header' => Yii::t('mailchimp/default', 'thumbnail'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'name',
            'header' => Yii::t('mailchimp/default', 'name'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'attribute' => 'file_size',
            'header' => Yii::t('mailchimp/default', 'file_size'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'attribute' => 'created_at',
            'header' => Yii::t('mailchimp/default', 'created_at'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'attribute' => 'size',
            'header' => Yii::t('mailchimp/default', 'size'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],
        /*[
            'attribute' => 'status',
            'header' => Yii::t('mailchimp/default', 'status'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],*/
        [
            'attribute' => 'options',
            'header' => Yii::t('app/default', 'OPTIONS'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ]

    ]
]);
Pjax::end();
