<?php

/**
 * @var app\modules\contacts\models\SettingsForm $model
 * @var panix\engine\bootstrap\ActiveForm $form
 * @var \DrewM\MailChimp\MailChimp $response
 */

$response = Yii::$app->mailchimp->getClient()->get("lists", ['fields' => ['id', 'name']]);


//\panix\engine\CMS::dump($response);die;
$items = [];
foreach ($response['lists'] as $data) {
    $items[$data['id']] = $data['name'];
}
?>


<?= $form->field($model, 'list_user')->dropDownList($items) ?>
<?= $form->field($model, 'list_order')->dropDownList($items) ?>
<?= $form->field($model, 'list_feedback')->dropDownList($items) ?>



<?php
$mailchimp = Yii::$app->mailchimp->getClient();


$result = $mailchimp->post('lists/5cc796a017/members', [
    //'merge_fields' => [
    //    'FNAME' => $fname,
    //    'LNAME' => $lname
    //],
    'email_address' => 'tester@gmail.com',
    'status' => 'subscribed',
]);

if(!$mailchimp->success()){

}
\panix\engine\CMS::dump($result);