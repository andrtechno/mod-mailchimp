<?php

use panix\engine\Html;
use panix\engine\widgets\Pjax;
use panix\engine\grid\GridView;

/**
 * @var \yii\data\ArrayDataProvider $dataProvider
 * @var \yii\web\View $this
 */


Pjax::begin();
echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'layoutOptions' => [
        'title' => $this->context->pageName,
    ],
    'columns' => [
        [
            'attribute' => 'name',
            'header' => Yii::t('mailchimp/default', 'NAME'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'attribute' => 'emails_sent',
            'header' => Yii::t('mailchimp/default', 'emails_sent'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center','style'=>'width:150px'],
        ],
        [
            'attribute' => 'create_time',
            'header' => Yii::t('mailchimp/default', 'create_time'),
            'format' => 'raw',
            'class' => 'panix\engine\grid\columns\jui\DatepickerColumn',
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

