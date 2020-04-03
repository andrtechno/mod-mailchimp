<?php
use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;


?>
<div class="card">
    <div class="card-header">
        <h5>ds</h5>
    </div>
    <div class="card-body">


        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'firstname') ?>
        <?= $form->field($model, 'lastname') ?>
        <?= $form->field($model, 'address') ?>
        <?= $form->field($model, 'phone') ?>
        <?= $form->field($model, 'birthday') ?>
        <?= $form->field($model, 'status')->dropDownList([
            'subscribed' => 'subscribed',
            'unsubscribed' => 'unsubscribed',
            'cleaned' => 'cleaned',
            'pending' => 'pending',
        ]);
        ?>
        <?= $form->field($model, 'type')->dropDownList([
            'html' => 'html',
            'text' => 'text'
        ]);
        ?>

        <div class="form-group text-center">
            <?= Html::submitButton(Yii::t('app/default', 'SEND'), ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
