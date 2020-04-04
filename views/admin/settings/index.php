<?php

use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;

$response = Yii::$app->mailchimp->getClient()->get("/");

$form = ActiveForm::begin();

$tabs[] = [
    'label' => $model::t('TAB_GENERAL'),
    'content' => $this->render('_main', ['form' => $form, 'model' => $model]),
    'active' => true,
];

if ($response) {
    $model->setScenario('api');
    $tabs[] = [
        'label' => $model::t('TAB_GENERAL2'),
        'content' => $this->render('_main2', ['form' => $form, 'model' => $model]),
    ];
}else{
    $model->setScenario('api_no');
}
?>
    <div class="card">
        <div class="card-header">
            <h5><?= $this->context->pageName ?></h5>
        </div>
        <div class="card-body">
            <?php
            echo yii\bootstrap4\Tabs::widget([
                'items' => $tabs,
            ]);
            ?>
        </div>
        <div class="card-footer text-center">
            <?= Html::submitButton(Yii::t('app/default', 'SAVE'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>