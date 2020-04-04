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







//\panix\engine\CMS::dump($response);