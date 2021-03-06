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

        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'html')->widget(\panix\ext\tinymce\TinyMce::class, [
            'options' => ['rows' => 6],
        ]);
        ?>
        <?= $form->field($model, 'folder_id') ?>

        <div class="form-group text-center">
            <?= Html::submitButton(Yii::t('app/default', 'SAVE'), ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
