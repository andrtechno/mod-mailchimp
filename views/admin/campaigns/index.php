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
            'header' => Yii::t('mailchimp/default', 'name'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'attribute' => 'url',
            'header' => Yii::t('mailchimp/default', 'url'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'emails_sent',
            'header' => Yii::t('mailchimp/default', 'emails_sent'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'content_type',
            'header' => Yii::t('mailchimp/default', 'content_type'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center','style'=>'width:150px'],
        ],
        [
            'attribute' => 'needs_block_refresh',
            'header' => Yii::t('mailchimp/default', 'needs_block_refresh'),
            'format' => 'html',
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






echo \panix\mod\mailchimp\widgets\Subscription::widget([
    'list_id' => '5cc796a017' // if not set raise Error
]);
