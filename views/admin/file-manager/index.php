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
    'showFooter' => true,
    'footerRowOptions' => ['style' => 'font-weight:bold;', 'class' => 'text-center'],
    'layoutOptions' => [
        'title' => $this->context->pageName,
        'buttons' => [
            [
                'label' => Yii::t('mailchimp/default', 'UPLOAD_FILE'),
                'url' => ['upload'],
                'icon' => 'upload',
                'options' => ['class' => 'btn btn-success']
            ],
            [
                'label' => Yii::t('mailchimp/default', 'ADD_FOLDER'),
                'url' => ['folder'],
                'icon' => 'add',
                'options' => ['class' => 'btn btn-secondary']
            ]
        ]
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
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'created_at',
            'class' => 'panix\engine\grid\columns\jui\DatepickerColumn',
            'header' => Yii::t('mailchimp/default', 'created_at'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'size',
            'header' => Yii::t('mailchimp/default', 'size'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
            'footer' =>$total_file_size,
        ],
        [
            'attribute' => 'folder',
            'header' => Yii::t('mailchimp/default', 'folder'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'options',
            'header' => Yii::t('app/default', 'OPTIONS'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ]

    ]
]);
Pjax::end();
