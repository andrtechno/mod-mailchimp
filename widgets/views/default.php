<?php
use panix\engine\Html;
echo Html::beginTag('div', array('class'=> 'col-md-12 text-center', 'id' => 'subscribe-div'));

if($message !== null && $message) {
    echo Html::tag('div', $message, array('id' => 'subscribe-message', 'class' => 'alert '.$class));
}

echo Html::beginForm();

if(Yii::$app->getModule('mailchimp')->showFirstname) {
    echo Html::beginTag('div', array('class'=> 'col-md-6 col-sm-6 text-center'));
    echo Html::textInput('subscribe-first-name',(empty($this->context->_post['subscribe-first-name']) ? '' : $this->context->_post['subscribe-first-name']), ['id' => 'subscribe-first-name','placeholder'=> Yii::t('mailchimp/default', 'First Name'), 'class'=> 'form-control']);
    echo Html::endTag('div');
}

if(Yii::$app->getModule('mailchimp')->showLastname) {
    echo Html::beginTag('div', array('class'=> 'col-md-6 col-sm-6 text-center'));
    echo Html::textInput('subscribe-last-name',(empty($this->context->_post['subscribe-last-name']) ? '' : $this->context->_post['subscribe-last-name']), ['id' => 'subscribe-last-name','placeholder'=> Yii::t('mailchimp/default', 'Last Name'), 'class'=> 'form-control']);
    echo Html::endTag('div');
}

echo Html::beginTag('div', array('class'=> 'col-md-12 text-center'));
echo Html::textInput('subscribe-email', (empty($this->context->_post['subscribe-email']) ? '' : $this->context->_post['subscribe-email']), ['id' => 'subscribe-email', 'type' => 'email','placeholder'=> Yii::t('mailchimp/default', 'Email'), 'required' => 'required', 'class'=> 'form-control']);
echo Html::endTag('div');

echo Html::beginTag('div', array('class'=> 'col-md-12 text-center'));
echo Html::submitButton(Yii::t('mailchimp', 'Submit'), array('id' => 'subscribe-submit', 'name' => 'subscribe-submit', 'class'=> 'btn btn-primary'));
echo Html::endTag('div');

echo Html::endForm();

echo Html::endTag('div');