<?php

namespace panix\mod\mailchimp;

use Yii;
use panix\engine\WebModule;
use yii\i18n\PhpMessageSource;

class Module extends WebModule
{
	// Rules
	public $roles = ['admin'];

	// Show Firstname in Widget
    public $showFirstname = true;

	// Show Lastname in Widget
    public $showLastname = true;

	// Show Titles in the views
	public $showTitles = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
	    $this->registerTranslations();

        parent::init();
    }

    /**
     * Translating module message
     */
    public function registerTranslations()
    {
        if (!isset(Yii::$app->i18n->translations['mailchimp*']))
        {
            Yii::$app->i18n->translations['mailchimp*'] = [
                'class' => PhpMessageSource::class,
                'basePath' => __DIR__ . '/messages',
            ];
        }
    }
}
