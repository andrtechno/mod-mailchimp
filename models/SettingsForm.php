<?php

namespace panix\mod\mailchimp\models;

use Yii;
use panix\engine\SettingsModel;

/**
 * Class SettingsForm
 * @package panix\mod\mailchimp\models
 */
class SettingsForm extends SettingsModel
{

    public static $category = 'mailchimp';
    protected $module = 'mailchimp';

    public $api_key;


    public function rules()
    {
        return [
           // ['schedule', 'validateSchedule', 'skipOnEmpty' => true],
           // ['address', 'validateLang', 'skipOnEmpty' => true],
            [['api_key'], "required"],
            [['api_key'], 'string'],
        ];
    }

    public static function defaultSettings()
    {
        return [
            'api_key' => '',
        ];
    }
}