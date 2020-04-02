<?php

namespace panix\mod\mailchimp;

use Yii;
use panix\engine\WebModule;
use yii\i18n\PhpMessageSource;

class Module extends WebModule
{


	// Show Firstname in Widget
    public $showFirstname = true;

	// Show Lastname in Widget
    public $showLastname = true;

	// Show Titles in the views
	public $showTitles = false;

}
