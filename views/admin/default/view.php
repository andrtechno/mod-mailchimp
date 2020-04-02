<?php
use yii\helpers\Html;
use panix\engine\CMS;
use panix\engine\widgets\Pjax;
use panix\engine\grid\GridView;

/**
 * @var string $name
 * @var integer $id
 * @var array $members
 */


Pjax::begin();
echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'layoutOptions' => [
        'title' => $this->context->pageName,
        'buttons' => [
            [
                'label' => Yii::t('mailchimp/default', 'CREATE_MEMBER'),
                'url' => ['create-member', 'id' => $id],
                'icon' => 'add',
                'options' => ['class' => 'btn btn-success']
            ]
        ]
    ],
    'columns' => [
        [
            'attribute' => 'name',
            'header' => Yii::t('app/default', 'name'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'attribute' => 'status',
            'header' => Yii::t('app/default', 'status'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'email',
            'header' => 'E-mail',
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'date',
            'header' => Yii::t('mailchimp/default', 'SUB_DATE'),
            'format' => 'raw',
            'class' => 'panix\engine\grid\columns\jui\DatepickerColumn',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'ip_opt',
            'header' => Yii::t('mailchimp/default', 'ip_opt'),
            'format' => 'raw',
            'contentOptions' => ['class' => 'text-center'],
        ],
    ]
]);
Pjax::end();
?>
