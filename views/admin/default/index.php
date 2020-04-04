<?php

use panix\engine\Html;
use panix\engine\widgets\Pjax;
use panix\engine\grid\GridView;
use panix\engine\CMS;

/**
 * @var \yii\data\ArrayDataProvider $dataProvider
 * @var \yii\web\View $this
 */


$responseRoot = Yii::$app->mailchimp->getRoot();

?>
<div class="row">
    <div class="col-sm-6">
        <?php
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
                    'attribute' => 'subscribe',
                    'header' => Yii::t('mailchimp/default', 'COUNT_SUBSCRIBE'),
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center', 'style' => 'width:150px'],
                ],
                [
                    'attribute' => 'unsubscribe',
                    'header' => Yii::t('mailchimp/default', 'COUNT_UNSUBSCRIBE'),
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center', 'style' => 'width:150px'],
                ],
                [
                    'attribute' => 'options',
                    'header' => Yii::t('app/default', 'OPTIONS'),
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center', 'style' => 'width:150px'],
                ],
            ]
        ]);
        Pjax::end();

        ?>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <h5>Информация об аккаунте</h5>
            </div>
            <div class="card-body">
                <div class="grid-view">
                    <table class="table table-striped">
                        <tr>
                            <th class="text-center">img</th>
                            <th class="text-left">name</th>
                            <th class="text-center">Дата регистрации</th>
                            <th class="text-center">Последний визит</th>
                            <th class="text-center">Подписчики</th>
                            <th class="text-center">email</th>
                        </tr>
                        <tr>
                            <td><?= Html::img($responseRoot['avatar_url'], ['style' => 'width:50px', 'class' => 'img-thumbnail']); ?></td>
                            <td class="text-left">
                                <?= $responseRoot['first_name']; ?> <?= $responseRoot['last_name']; ?>
                                <br/>
                                <span class="badge badge-secondary"><?= $responseRoot['role']; ?></span>
                                <span class="badge badge-secondary"><?= $responseRoot['pricing_plan_type']; ?></span>
                            </td>
                            <td class="text-center"><?= CMS::date(strtotime($responseRoot['member_since']), false); ?></td>
                            <td class="text-center"><?= CMS::date(strtotime($responseRoot['last_login'])); ?></td>
                            <td class="text-center"><span
                                        class="badge badge-secondary"><?= $responseRoot['total_subscribers']; ?></span>
                            </td>
                            <td class="text-center"><?= $responseRoot['email']; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$responseVerified = Yii::$app->mailchimp->getClient()->get("verified-domains");
?>
<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <h5>Проверенные домены</h5>
            </div>
            <div class="card-body">
                <div class="grid-view">
                    <table class="table table-striped">
                        <tr>
                            <th class="text-center">domain</th>
                            <th class="text-left">verified</th>
                            <th class="text-center">authenticated</th>
                            <th class="text-center">verification_email</th>
                            <th class="text-center">verification_sent</th>
                        </tr>
                        <?php foreach ($responseVerified['domains'] as $data) { ?>
                            <tr>
                                <td><?= $data['domain']; ?></td>
                                <td><?= ($data['verified']) ? Html::tag('span', 'Verified', ['class' => 'badge badge-success']) : 'no'; ?></td>
                                <td><?= ($data['authenticated']) ? 'yes' : 'no'; ?></td>
                                <td><?= $data['verification_email']; ?></td>
                                <td><?= $data['verification_sent']; ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php


$response = Yii::$app->mailchimp->getClient()->get("activity-feed/chimp-chatter");


foreach ($response['chimp_chatter'] as $data) {

    $responseList = Yii::$app->mailchimp->getClient()->get("/lists/{$data['list_id']}");

    //CMS::dump($responseList);die;

    $result[] = [
        'title' => $data['title'] . Html::tag('div', $data['message'], ['class' => 'text-muted']),
        'list' => $responseList['name'],
        'campaign_id' => $data['campaign_id'],
        'update_time' => strtotime($data['update_time']),
        'type' => Html::tag('span', $data['type'], ['class' => 'badge badge-secondary']),
        'url' => $data['url'],
        // 'needs_block_refresh' => ($data['needs_block_refresh'])?'yes':'no',
        //'options' => Html::a(Html::icon('search'), ['view', 'id' => $data['id']], ['class' => 'btn btn-sm btn-outline-secondary']).Html::a(Html::icon('brush'), ['content', 'id' => $data['id']], ['class' => 'btn btn-sm btn-outline-secondary']),
    ];
}

$dataProvider = new \yii\data\ArrayDataProvider([
    'allModels' => $result,
    'pagination' => [
        'pageSize' => 10,
    ]
]);


?>
<div class="row">
    <div class="col-sm-12">

        <?php
        echo GridView::widget([
            'tableOptions' => ['class' => 'table table-striped'],
            'dataProvider' => $dataProvider,
            'layoutOptions' => [
                'title' => 'Активность',
            ],
            'columns' => [
                [
                    'attribute' => 'title',
                    'header' => Yii::t('mailchimp/default', 'NAME'),
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-left'],
                ],
                [
                    'attribute' => 'list',
                    'header' => Yii::t('mailchimp/default', 'list'),
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center', 'style' => 'width:150px'],
                ],
                [
                    'attribute' => 'type',
                    'header' => Yii::t('mailchimp/default', 'type'),
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center', 'style' => 'width:150px'],
                ],
                [
                    'attribute' => 'url',
                    'header' => Yii::t('mailchimp/default', 'url'),
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center'],
                ],
                [
                    'attribute' => 'update_time',
                    'class' => 'panix\engine\grid\columns\jui\DatepickerColumn',
                    'header' => Yii::t('app/default', 'update_time'),
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center', 'style' => 'width:150px'],
                ],
            ]
        ]);
        ?>
    </div>
</div>


<?php
$response = Yii::$app->mailchimp->getClient()->get("reports");
CMS::dump($response);