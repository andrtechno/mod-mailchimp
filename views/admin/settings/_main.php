<?php

use panix\ext\taginput\TagInput;
/**
 * @var app\modules\contacts\models\SettingsForm $model
 * @var panix\engine\bootstrap\ActiveForm $form
 */



?>


<?= $form->field($model, 'api_key')->textInput() ?>
<?=
$form->field($model, 'test_emails')
    ->widget(TagInput::class, ['placeholder' => 'E-mail'])
    ->hint('Введите E-mail и нажмите Enter');
?>

<?= $form->field($model, 'test_send_type')->dropDownList(['html'=>'html','plaintext'=>'plain/text']) ?>

