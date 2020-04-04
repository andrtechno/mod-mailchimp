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
            'attribute' => 'domain',
            'header' => Yii::t('mailchimp/default', 'domain'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'attribute' => 'site_script',
            'header' => Yii::t('mailchimp/default', 'site_script'),
            'format' => 'html',
            'contentOptions' => ['class' => 'text-left'],
            'value' => function ($model) {
                return '<code>' . $model['site_script']['url'] . '</code><br/><code>' . Html::encode($model['site_script']['fragment']) . '</code>';
            }
        ],
        [
            'attribute' => 'created_at',
            'header' => Yii::t('mailchimp/default', 'created_at'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center', 'style' => 'width:150px'],
        ],
        [
            'attribute' => 'updated_at',
            'header' => Yii::t('mailchimp/default', 'updated_at'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center', 'style' => 'width:150px'],
        ],
    ]
]);
Pjax::end();
