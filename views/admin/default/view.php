<?php
use panix\engine\Html;
use panix\engine\CMS;
use panix\engine\widgets\Pjax;
use panix\engine\grid\GridView;

/**
 * @var string $name
 * @var integer $id
 * @var \yii\data\ArrayDataProvider $dataProvider
 * @var \yii\web\View $this
 */


?>
    <div class="row">
        <div class="col-sm-6">
            <?php
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
                            'url' => ['create-member', 'id' => $id, 'name' => $name],
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
                        'header' => Yii::t('mailchimp/default', 'STATUS'),
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
                        'header' => Yii::t('mailchimp/default', 'IP'),
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'attribute' => 'options',
                        'header' => Yii::t('app/default', 'OPTIONS'),
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                ]
            ]);
            Pjax::end();

            ?>
        </div>
        <div class="col-sm-6">
            <?php
            $response = Yii::$app->mailchimp->getClient()->get("/lists/{$id}/growth-history");


            foreach ($response['history'] as $data) {
                $result[] = [
                    'month' => $data['month'],
                    'existing' => $data['existing'],
                    'imports' => $data['imports'],
                    'optins' => $data['optins'],
                    'subscribed' => Html::tag('span', $data['subscribed'], ['class' => 'badge badge-success']),
                    'unsubscribed' => Html::tag('span', $data['unsubscribed'], ['class' => 'badge badge-danger']),
                    'reconfirm' => $data['reconfirm'],
                    'cleaned' => $data['cleaned'],
                    'pending' => $data['pending'],
                    'deleted' => $data['deleted'],
                    'transactional' => $data['transactional'],
                ];
            }

            $dataProviderHistory = new \yii\data\ArrayDataProvider([
                'allModels' => $result,
                'pagination' => [
                    'pageSize' => 10,
                ]
            ]);


            echo GridView::widget([
                'tableOptions' => ['class' => 'table table-striped'],
                'dataProvider' => $dataProviderHistory,
                'layoutOptions' => [
                    'title' => Yii::t('mailchimp/default', 'HISTORY'),
                ],
                'columns' => [
                    [
                        'attribute' => 'month',
                        'header' => Yii::t('app/default', 'month'),
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-left'],
                    ],
                    [
                        'attribute' => 'existing',
                        'header' => Yii::t('mailchimp/default', 'existing'),
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'attribute' => 'imports',
                        'header' => 'imports',
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'attribute' => 'optins',
                        'header' => Yii::t('mailchimp/default', 'optins'),
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'attribute' => 'subscribed',
                        'header' => Yii::t('mailchimp/default', 'SUBSCRIBED'),
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'attribute' => 'unsubscribed',
                        'header' => Yii::t('mailchimp/default', 'UNSUBSCRIBED'),
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'attribute' => 'reconfirm',
                        'header' => Yii::t('mailchimp/default', 'reconfirm'),
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'attribute' => 'cleaned',
                        'header' => Yii::t('mailchimp/default', 'CLEANED'),
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'attribute' => 'pending',
                        'header' => Yii::t('mailchimp/default', 'PENDING'),
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'attribute' => 'transactional',
                        'header' => Yii::t('mailchimp/default', 'TRANSACTIONAL'),
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                ]
            ]);

            ?>
        </div>
    </div>

<?php

$response2 = Yii::$app->mailchimp->getClient()->get("/lists/{$id}/merge-fields");
//CMS::dump($response2);die;

$result2=[];
foreach ($response2['merge_fields'] as $data) {
    $required = ($data['required']) ? Html::tag('span', 'required', ['class' => 'badge badge-danger']) : '';
    $public = ($data['public']) ? Html::tag('span', 'public', ['class' => 'badge badge-warning']) : '';
    $result2[] = [
        'name' => $data['name'] . ' [tag: ' .$data['tag'].']<br/>'. $required.' '.$public,
        'default_value' => ($data['default_value'])?$data['default_value']:null,
        'type'=>Html::tag('span', $data['type'], ['class' => 'badge badge-secondary']),
        'options' => Html::a(Html::icon('edit'), ['megr', 'list_id' => $data['merge_id']], ['class' => 'btn btn-sm btn-outline-secondary']),
    ];
}

$dataProviderFields = new \yii\data\ArrayDataProvider([
    'allModels' => $result2,
    'pagination' => [
        'pageSize' => 10,
    ]
]);


echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProviderFields,
    'layoutOptions' => [
        'title' => Yii::t('mailchimp/default', 'fierlds'),
    ],
    'columns' => [
        [
            'attribute' => 'name',
            'header' => Yii::t('app/default', 'name'),
            'format' => 'html',
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'attribute' => 'type',
            'header' => Yii::t('app/default', 'type'),
            'format' => 'html',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'default_value',
            'header' => Yii::t('app/default', 'default_value'),
            'format' => 'html',
            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'attribute' => 'options',
            'header' => Yii::t('app/default', 'OPTIONS'),
            'format' => 'html',
            'contentOptions' => ['class' => 'text-left'],
        ],
    ]
]);

?>