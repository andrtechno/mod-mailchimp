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
            'contentOptions' => ['class' => 'text-center','style'=>'width:150px'],
        ],
        [
            'attribute' => 'name',
            'header' => Yii::t('mailchimp/default', 'NAME'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],

        [
            'attribute' => 'type',
            'header' => Yii::t('mailchimp/default', 'type'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],

        [
            'attribute' => 'category',
            'header' => Yii::t('mailchimp/default', 'category'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'responsive',
            'header' => Yii::t('mailchimp/default', 'responsive'),
            'format' => 'boolean',
            'contentOptions' => ['class' => 'text-center'],
        ],
         [
            'attribute' => 'options',
            'header' => Yii::t('app/default', 'OPTIONS'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center','style'=>'width:150px'],
        ],
    ]
]);
Pjax::end();

