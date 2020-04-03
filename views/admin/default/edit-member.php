<?php
use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;

print_r($model->attributes);
?>
<div class="card">
    <div class="card-header">
        <h5>ds</h5>
    </div>
    <div class="card-body">


        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'email_address') ?>

        <?= $form->field($model, 'email_type')->dropDownList([
            'html' => 'html',
            'text' => 'text'
        ]);
        ?>
        <?= $form->field($model, 'status')->dropDownList([
            'subscribed' => 'subscribed',
            'unsubscribed' => 'unsubscribed',
            'cleaned' => 'cleaned',
            'pending' => 'pending',
        ]);

        foreach ($inputs as $input_key => $input) {
            if($input['type']=='text' || $input['type']=='address' || $input['type']=='birthday' || $input['type']=='phone' || $input['type']=='imageurl'){
                echo $form->field($model, $input_key)->label($input['label']);
            }elseif($input['type']=='dropdown'){
                echo $form->field($model, $input_key)->dropDownList($input['items'])->label($input['label']);
            }elseif($input['type']=='radio'){
                echo $form->field($model, $input_key)->radioList($input['items'])->label($input['label']);
            }

        }

        ?>

        <div class="form-group text-center">
            <?= Html::submitButton(Yii::t('app/default', 'SEND'), ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
